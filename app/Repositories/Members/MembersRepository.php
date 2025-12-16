<?php

namespace App\Repositories\Members;

use App\Models\Member;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class MembersRepository implements MembersRepositoryInterface
{
    public function __construct(
        protected Member $model
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
     * Find member by id.
     */
    public function find(int $id): ?Member
    {
        return $this->model->find($id);
    }

    /**
     * Create a new member.
     */
    public function create(array $data): Member
    {
        return $this->model->create($data);
    }

    /**
     * Update a member by id.
     */
    public function update(int $id, array $data): bool
    {
        $member = $this->find($id);

        if (! $member) {
            return false;
        }

        return $member->update($data);
    }

    /**
     * Delete a member by id.
     */
    public function delete(int $id): bool
    {
        $member = $this->find($id);

        if (! $member) {
            return false;
        }

        return (bool) $member->delete();
    }

    /**
     * Get member by project name.
     */
    public function getMemberByProject($project_name): Collection
    {
        $member = $this->model->join('projects','projects.id','members.project_id')
                    ->where('projects.project_name', $project_name)
                    ->select('members.*')
                    ->get();
        return $member;
    }

    /**
     * Delete member from project.
     */
    public function deleteMemberFromProject(int $memberId): bool
    {
        $member = $this->find($memberId);
        if (! $member) {
            return false;
        }
        return (bool) $member->update(['project_id' => null]);
    }
}


