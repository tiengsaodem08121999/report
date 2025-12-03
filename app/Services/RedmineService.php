<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class RedmineService
{
    protected $client;
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->baseUrl = 'https://redmine.splus-software.com';
        $this->apiKey = 'c8b8b032bbcd19995fe294d1f193c9b7f66a8aaa';
    }

     /**
     * Lấy logtime (time_entries) theo ngày và project
     */
    public function getLogTime(string $projectId, string $date)
    {
        $response = Http::withHeaders([
            'X-Redmine-API-Key' => $this->apiKey,
        ])->get("{$this->baseUrl}/time_entries.json", [
            'project_id' => $projectId,
            'from'       => $date,
            'to'         => $date,
            'limit'      => 1000,
        ]);

        if ($response->failed()) {
            return [
                'success' => false,
                'error'   => $response->body(),
            ];
        }

        return $response->json()['time_entries'] ?? [];
    }

    public function getIssueById(int $issueId)
    {
        $response = Http::withHeaders([
            'X-Redmine-API-Key' => $this->apiKey,
        ])->get("{$this->baseUrl}/issues/{$issueId}.json");

        if ($response->failed()) {
            return [
                'success' => false,
                'error'   => $response->body(),
            ];
        }

        return $response->json()['issue'] ?? null;
    }
    
    public function fetchDailyReport(string $date, string $projectIdentifier)
    {
        $logTimeResponse = $this->getLogTime($projectIdentifier, $date);
        $data = [];
        if(isset($logTimeResponse)) {
            foreach ($logTimeResponse as &$entry) {
                $developer = $entry['user']['name'] ?? 'Unknown';
                $hours = 0;
                $issueId = $entry['issue']['id'] ?? null;
                if ($issueId) {
                    $issueDetails = $this->getIssueById($issueId);
                    $data[$developer][] = [
                        'id' => $entry['id'],
                        'title' => $issueDetails['tracker']['name'] . ' #' . $issueDetails['id'] . ': ' . $issueDetails['subject'],
                        'status' => $issueDetails['status']['name'],
                        'hours' => $hours + $entry['hours'],
                    ];
                }
            }
        }
        return $data;
    }

   public function logTimeToRedmine(array $data)
    {
        $redmineUrl = $this->baseUrl;
        $apiKey =  $data['key'];
        $result = [];

        $response = Http::withHeaders([
            'X-Redmine-API-Key' => $apiKey,
            'Content-Type' => 'application/json',
        ])->post("$redmineUrl/time_entries.json", [
            'time_entry' => [
                'issue_id'    => (int) $data['task_id'],
                'hours'       => $data['hours'],
                'spent_on'    => Carbon::parse($data['spent_on'])->format('Y-m-d'),
                'activity_id' => $data['activity_id'],
            ]
        ]); 

        if ($response->failed()) {
            $result = [
                'error' => 'Failed to log time on Redmine: ' . $response->body(),
            ];
            return $result;
        }
        return $response->json();
    }

     /**
     * Delete log time entry from Redmine
     *
     * @param int $timeEntryId
     * @param string $user
     * @return bool
     */
    public function deleteLogTime(int $timeEntryId, string $userKey)
    {
        $result = [];
        $url = rtrim($this->baseUrl, '/') . "/time_entries/{$timeEntryId}.json";

        $response = Http::withHeaders([
            'X-Redmine-API-Key' => $userKey,
            'Content-Type' => 'application/json',
        ])->delete($url);

        // Redmine trả về 204 No Content nếu xoá thành công
        $result = [
            'status' => $response->status(),
        ];
        return $result;
    }

      /**
     * Lấy danh sách user đã log time trong ngày và nhóm theo user
     */
    public function getUserTasks($date, $project_id)
    {
        $data = $this->fetchTimeEntries($date);
        
        if (isset($data['error'])) {
            return $data;
        }

        $groupedTasks = [];

        foreach ($data['time_entries'] as $entry) {
            if($entry['project']['id'] == (int)$project_id) {
                $user = $entry['user']['name'];
                $taskId = $entry['issue']['id'];
                $taskName = $this->fetchTaskDetail($taskId);
                $taskFormatted = $taskName['tracker'] . ' #' . $taskName['id'] . ' :'  . $taskName['subject'] . ' ';
                $groupedTasks[$user][] = [
                    'id' => $entry['id'],
                    'task' => $taskFormatted,
                    'status' => $taskName['status'],
                    'spent_time' => $entry['hours'],
                ];
            }
        }
        return $groupedTasks;
    }

     /**
     * Gọi API Redmine để lấy danh sách log time theo ngày
     */
    public function fetchTimeEntries($date)
    {
        try {
            $response = $this->client->request('GET', "{$this->baseUrl}/time_entries.json", [
                'query' => [
                    'spent_on' => $date,
                    'key' => $this->apiKey
                ]
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            Log::error("Redmine API Error: " . $e->getMessage());
            return ['error' => 'Không thể lấy dữ liệu từ Redmine'];
        }
    }

    /**
     * Gọi API để lấy chi tiết task theo ID
     */
    public function fetchTaskDetail($taskId)
    {
        try {
            $response = $this->client->request('GET', "{$this->baseUrl}/issues/{$taskId}.json", [
                'query' => ['key' => $this->apiKey]
            ]);
            $data = json_decode($response->getBody()->getContents(), true);

            $subject = $data['issue']['subject'] ?? 'Không có tiêu đề';
            $tracker = $data['issue']['tracker']['name'] ?? 'Không có tracker';
            $status = $data['issue']['status']['name'] ?? 'Không có status';

            return [
                'id' => $taskId,
                'subject' => $subject,
                'tracker' => $tracker,
                'status' => $status
            ];
        } catch (\Exception $e) {
            Log::error("Lỗi khi lấy thông tin task: " . $e->getMessage());
            return "Không thể lấy task";
        }
    }

    public function createDailyReport($data, $project)
    {
        try {
            $today = date('Y-m-d');
            $subject = '日報　' . date('Y年n月j日');
            // Today's tasks section
            $description = "*1.【本日のタスク】*\n\n";
            $description .= $this->formatTasksTable($data) . "\n\n";
            $response = $this->client->request('POST', "{$this->baseUrl}/issues.json", [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-Redmine-API-Key' => $this->apiKey
                ],
                'json' => [
                    'issue' => [
                        'project_id' => $project,
                        'subject' => $subject,
                        'status_id' => 1, // New status
                        'tracker_id' => 8, // Report
                        'start_date' => $today,
                        'due_date' => $today,
                        'description' => $description,
                        'assigned_to_id' => 758 // DuongNT
                    ]
                ]
            ]);
            if ($response->getStatusCode() !== 201) {
                return ['error' => 'Không thể tạo báo cáo trên Redmine'];
            }
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            Log::error("Redmine API Error: " . $e->getMessage());
            return ['error' => 'Không thể tạo báo cáo trên Redmine'];
        }
    }

    private function formatTasksTable($data)
    {
        $table = "|_. # |_. 開発者 |_. ID タスク |_. ステータス |_. 備考 |\n";
        $index = 1;
        $splus = 'Splus.';
        $developers = config('information.developer_report');

        foreach ($developers as $dev) {
            $taskContents = [];
            $taskStatuses = [];

            if (isset($data[$dev])) {
                foreach ($data[$dev] as $task) {
                    // Task content
                    $taskContent = is_array($task['task']) ? implode("\n", $task['task']) : $task['task'];
                    $taskContents[] = $taskContent;

                    // Status
                    $status = is_array($task['status']) ? implode("\n", $task['status']) : $task['status'];
                    $taskStatus = $status == 'Closed' || $status == 'Resolved' ? '完了' : '進行中';
                    $taskStatuses[] = $taskStatus;
                }
            }

            $taskColumn = implode("\n", $taskContents);
            $statusColumn = implode("\n", $taskStatuses);

            $table .= "| {$index} |{$splus}{$dev}| {$taskColumn} | {$statusColumn}|. |\n";
            $index++;
        }

        return $table;
    }
}