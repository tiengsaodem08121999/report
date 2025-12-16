<?php

namespace App\Repositories\Members;

use App\Models\Member;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface MembersRepositoryInterface
{
    /**
     * Get all members.
     *
     * @return \Illuminate\Support\Collection<int, \App\Models\Members>
     */
    public function getAll(): Collection;

    /**
     * Get paginated members list.
     */
    public function paginate(int $perPage = 15): LengthAwarePaginator;

    /**
     * Find member by id.
     */
    public function find(int $id): ?Member;

    /**
     * Create a new member.
     */
    public function create(array $data): Member;

    /**
     * Update a member by id.
     */
    public function update(int $id, array $data): bool;

    /**
     * Delete a member by id.
     */
    public function delete(int $id): bool;

    /**
     * Get member by project name.
     */
    public function getMemberByProject(int $project_name): Collection;

    /**
     * Delete member from project.
     */
    public function deleteMemberFromProject(int $memberId): bool;
}


