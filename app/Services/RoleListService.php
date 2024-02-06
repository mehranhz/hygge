<?php

namespace App\Services;

use App\DTO\PaginatedData;
use App\Repository\RoleRepositoryInterface;
use App\Services\Contracts\RoleListInterface;

class RoleListService implements RoleListInterface
{
    private RoleRepositoryInterface $roleRepository;

    /**
     * @param RoleRepositoryInterface $roleRepository
     */
    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * @param array $query
     * @return PaginatedData
     */
    public function find(array $query): PaginatedData{
        return $this->roleRepository->get($query);
    }
}
