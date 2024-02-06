<?php

namespace App\Services;

use App\DTO\PaginatedData;
use App\Exceptions\ErrorCode;
use App\Exceptions\ServiceCallException;
use App\Repository\RoleRepositoryInterface;
use App\Services\Contracts\RoleListInterface;
use Illuminate\Support\Facades\Log;

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
    public function find(array $query): PaginatedData
    {
        try {
            return $this->roleRepository->get($query);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw new ServiceCallException('failed to get roles list', code: ErrorCode::Unknown->value);
        }
    }
}
