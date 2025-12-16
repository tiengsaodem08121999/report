<?php

namespace App\Repositories\Projects;

use App\Models\Projects;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ProjectsRepository implements ProjectsRepositoryInterface
{
    public function __construct(
        protected Projects $model
    ) {
    }

    /**
     * Get all members.
     */
    public function getAll(): Collection
    {
        return $this->model->all();
    }

    /**
     * Get paginated members list.
     */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->paginate($perPage);
    }

    /**
     * Find project by id.
     */
    public function find(int $id): ?Projects
    {
        return $this->model->find($id);
    }

    /**
     * Find project by Key.
     */
    public function getProjetByKey(array $key): ?Projects
    {
        $model =  $this->model;
        if (isset($key['redmine_project_id'])) {
            $model = $model->where('redmine_project_id', $key['redmine_project_id']);
        }
        
        if (isset($key['project_name'])) {
            $model = $model->where('project_name', $key['project_name']);
        }

        return $model->first();
    }

    /**
     * Create a new project.
     */
    public function create(array $data): Projects
    {
        return $this->model->create($data);
    }

    /**
     * Update a project by id.
     */
    public function update(int $id, array $data): bool
    {
        $project = $this->find($id);

        if (! $project) {
            return false;
        }

        return $project->update($data);
    }

    /**
     * Delete a project by id.
     */
    public function delete(int $id): bool
    {
        $project = $this->find($id);

        if (! $project) {
            return false;
        }

        return (bool) $project->delete();
    }

    /**
     * Find project with member.
     */   
    public function getProjetWithMember(): Collection
    {
        $model =  $this->model->with('members')->get();
        return $model;
    } 
}


