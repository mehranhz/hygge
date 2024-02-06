<?php

namespace App\Services;

use App\Exceptions\ErrorCode;
use App\Exceptions\ServiceCallException;
use App\Repository\PermissionRepositoryInterface;
use App\Repository\RoleRepositoryInterface;
use App\Services\Contracts\RoleGivePermissionInterface;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class RoleGivePermissionService implements RoleGivePermissionInterface
{
    private RoleRepositoryInterface $roleRepository;
    private PermissionRepositoryInterface $permissionRepository;

    /**
     * @param RoleRepositoryInterface $roleRepository
     * @param PermissionRepositoryInterface $permissionRepository
     */
    public function __construct(RoleRepositoryInterface $roleRepository, PermissionRepositoryInterface $permissionRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * @param int $roleID
     * @param int $permissionID
     * @return void
     * @throws ServiceCallException
     */
    public function givePermissionToRole(int $roleID, int $permissionID): void
    {
        try {
            $permissionInstance = $this->permissionRepository->find($permissionID);
            $this->roleRepository->givePermissionToRole($roleID, $permissionInstance->name);

        } catch (RecordsNotFoundException $exception) {
            throw new ServiceCallException($exception->getMessage(), code: ErrorCode::ResourceNotFound->value, httpStatusCode: 404);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw new  ServiceCallException("failed to add permission with id: $permissionID to role with id:$roleID", ErrorCode::Unknown->value, httpStatusCode: 500);
        }
    }
}
