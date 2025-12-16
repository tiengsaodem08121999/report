<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Members\MembersRepositoryInterface;
use App\Repositories\Projects\ProjectsRepositoryInterface;
use App\Services\MemberService;

class MembersController extends Controller
{
    protected MembersRepositoryInterface $membersRepository;
    protected ProjectsRepositoryInterface $projectsRepository;
    protected $memberService;

    public function __construct(
        MembersRepositoryInterface $membersRepository, 
        ProjectsRepositoryInterface $projectsRepository,
        MemberService $memberService
        ) {
        $this->membersRepository = $membersRepository;
        $this->projectsRepository = $projectsRepository;
        $this->memberService = $memberService;
    }

    public function index() 
    {
        $members = $this->membersRepository->getAll();
        $projects = $this->projectsRepository->getAll();
        return view('pages.members.index', compact('members', 'projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'key' => 'required|string|max:255',
                'project_id' => 'nullable|integer',
            ]);
            $data = [
                'name' => $request->name,
                'key' => $request->key,
                'project_id' => $request->project_id,
            ];
            $this->memberService->createMember($data);
            return redirect()->route('members.index')->with('success', 'Member created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $members)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $members)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($members,Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'key' => 'required|string|max:255',
                'project_id' => 'nullable|integer',
            ]);
            $data = [
                'name' => $request->name,
                'key' => $request->key,
                'project_id' => $request->project_id,
            ];
            $this->memberService->updateMember($members, $data);
            return redirect()->route('members.index')->with('success', 'Member updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $members)
    {
        //
    }
}
