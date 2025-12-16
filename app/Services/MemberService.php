<?php

namespace App\Services;

use App\Repositories\Members\MembersRepositoryInterface;
use App\Repositories\Projects\ProjectsRepositoryInterface;

class MemberService
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

    public function createMember(array $data)
    {
        try {
            $this->membersRepository->create($data);
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function UpdateMember(int $id, array $data)
    {
        try {
            $updated = $this->membersRepository->update($id, $data);
            if (! $updated) {
                throw new \Exception('Member not found');
            }
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
   
}