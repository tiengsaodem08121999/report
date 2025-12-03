<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Members\MembersRepositoryInterface;
use App\Repositories\Projects\ProjectsRepositoryInterface;
use App\Services\RedmineService;

class ReportsController extends Controller
{

    protected MembersRepositoryInterface $membersRepository;
    protected ProjectsRepositoryInterface $projectsRepository;
    protected $redmineService;

    public function __construct(
        MembersRepositoryInterface $membersRepository, 
        ProjectsRepositoryInterface $projectsRepository,
        RedmineService $redmineService
        ) {
        $this->membersRepository = $membersRepository;
        $this->projectsRepository = $projectsRepository;
        $this->redmineService = $redmineService;
    }

    public function index(Request $request)
    {
        $date = $request->get('date') ?? now()->format('Y-m-d');
        $project = $request->get('project');
        session( ['data_search'=> ['date' => $date, 'project' => $project]]);
        $members = $this->membersRepository->getMemberByProject($project);
        $reports = [];
        if($project) {
            $reports = $this->redmineService->fetchDailyReport($date, $project);
        }
        return view('pages.report', compact('reports','members'));
    }

    public function store(Request $request)
    {
        $date = $request->get('date') ?? now()->format('Y-m-d');
        $project = $this->projectsRepository->getProjetByKey([$request->get('project')])->redmine_project_id;
        $data = $this->redmineService->getUserTasks($date, $project->redmine_project_id);
        $result = $this->redmineService->createDailyReport($data ,  $project->project_name);

        if (isset($result['error'])) {
            return redirect()->route('report')->with('error', $result['error']);
        }
        return redirect()->route('report')->with('success', 'Báo cáo đã được tạo thành công trên Redmine')
                ->with('report_id', $result['issue']['id']);  
    }
}
