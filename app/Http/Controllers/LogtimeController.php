<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RedmineService;

class LogtimeController extends Controller
{
    protected $redmineService;

    public function __construct(RedmineService $redmineService) 
    {
        $this->redmineService = $redmineService;
    }

    public function store(Request $request)
    {   
        $result = $this->redmineService->logTimeToRedmine($request->all());
        $data_search = session('data_search');
        if (isset($result['error'])) {
            return redirect()->route('report.index', $data_search)->with('error', $result['error']);
        }
        return redirect()->route('report.index', $data_search)->with('success', 'Log time đã được thực hiện thành công trên Redmine');
    }

    public function deleteSpentTime(Request $request)
    {
        $id = $request->input('id');
        $dev = $request->input('dev');
        $data_search = session('data_search');
        if (!$id || !$dev) {
            return redirect()->route('report.index', $data_search)->with('error', 'ID hoặc dev không hợp lệ');
        }
        $result = $this->redmineService->deleteLogTime((int) $id, $dev);
        if (isset($result['error'])) {
            return redirect()->route('report.index', $data_search)->with('error', $result['error']);
        }
        if ($result['status'] !== 204) {
            return redirect()->route('report.index', $data_search)->with('error', $result['status']);
        }

        return redirect()->route('report.index', $data_search)->with('success', 'Đã xóa spent time thành công');
    }
}
