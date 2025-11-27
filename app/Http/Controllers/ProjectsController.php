<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Projects\ProjectsRepositoryInterface;

class ProjectsController extends Controller
{
    protected ProjectsRepositoryInterface $projectsRepository;
      

    public function __construct (ProjectsRepositoryInterface $projectsRepository) 
    {
        $this->projectsRepository = $projectsRepository;
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    {   try {
            $request->validate([
                'project_name' => 'required|string|max:255',
            ]);
            $this->projectsRepository->create([
                'project_name' => $request->project_name,
            ]);
            return redirect()->route('members.index')->with('success', 'Project created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Projects $projects)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Projects $projects)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Projects $projects)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Projects $projects)
    {
        //
    }
}
