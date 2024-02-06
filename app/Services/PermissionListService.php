<?php

namespace App\Services;

use App\DTO\PaginatedData;
use App\Exceptions\ErrorCode;
use App\Exceptions\ServiceCallException;
use App\Repository\PermissionRepositoryInterface;
use App\Services\Contracts\PermissionListInterface;
use Illuminate\Support\Facades\Log;

class PermissionListService implements PermissionListInterface
{
    protected PermissionRepositoryInterface $permissionRepository;

    /**
     * @param PermissionRepositoryInterface $permissionRepository
     */
    public function __construct(PermissionRepositoryInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * @param array $query
     * @return PaginatedData
     * @throws ServiceCallException
     */
    public function find(array $query): PaginatedData
    {
        try {
            return $this->permissionRepository->get($query);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw new ServiceCallException('failed to get permission list', code: ErrorCode::Unknown->value);
        }
    }
}
