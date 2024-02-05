<?php

namespace App\Services;

use App\Repository\RoleRepositoryInterface;
use App\Services\Contracts\RoleListInterface;

class RoleListService implements RoleListInterface
{
    private RoleRepositoryInterface $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function find(array $query):array{
        return $this->roleRepository->get($query);
    }
}
