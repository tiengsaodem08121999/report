<?php

namespace App\Repositories\Projects;

use App\Models\Projects;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ProjectsRepositoryInterface
{
    /**
     * Get all projects.
     *
     * @return \Illuminate\Support\Collection<int, \App\Models\Projects>
     */
    public function getAll(): Collection;

    /**
     * Get paginated projects list.
     */
    public function paginate(int $perPage = 15): LengthAwarePaginator;

    /**
     * Find project by id.
     */
    public function find(int $id): ?Projects;

    /**
     * Create a new project.
     */
    public function create(array $data): Projects;

    /**
     * Update a project by id.
     */
    public function update(int $id, array $data): bool;

    /**
     * Delete a project by id.
     */
    public function delete(int $id): bool;
}


