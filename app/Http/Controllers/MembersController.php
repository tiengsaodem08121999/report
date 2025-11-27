<?php

namespace App\Http\Controllers;

use App\Models\Members;
use App\Repositories\Members\MembersRepositoryInterface;
use Illuminate\Http\Request;
use App\Repositories\Projects\ProjectsRepositoryInterface;

class MembersController extends Controller
{
    protected MembersRepositoryInterface $membersRepository;
    protected ProjectsRepositoryInterface $projectsRepository;

    public function __construct(
        MembersRepositoryInterface $membersRepository, 
        ProjectsRepositoryInterface $projectsRepository
        ) {
        $this->membersRepository = $membersRepository;
        $this->projectsRepository = $projectsRepository;
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Members $members)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Members $members)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Members $members)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Members $members)
    {
        //
    }
}
