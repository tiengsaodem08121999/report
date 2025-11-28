<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

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
                        'title' => $issueDetails['tracker']['name'] . ' #' . $issueDetails['id'] . ': ' . $issueDetails['subject'],
                        'status' => $issueDetails['status']['name'],
                        'hours' => $hours + $entry['hours'],
                    ];
                }
            }
        }
        return $data;
    }
}