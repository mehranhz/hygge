<?php

namespace App\Services;

use App\Entity\Permission;
use App\Exceptions\ErrorCode;
use App\Exceptions\ServiceCallException;
use App\Repository\PermissionRepositoryInterface;
use App\Services\Contracts\PermissionCreateInterface;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Exceptions\PermissionAlreadyExists;

class PermissionCreateService implements PermissionCreateInterface
{
    private PermissionRepositoryInterface $permissionRepository;

    /**
     * @param PermissionRepositoryInterface $permissionRepository
     */
    public function __construct(PermissionRepositoryInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }


    /**
     * @param array $attributes
     * @return Permission
     * @throws ServiceCallException
     */
    public function create(array $attributes): Permission
    {
        try {
            $permission_model_instance = $this->permissionRepository->create([
                "name" => $attributes["name"]
            ]);

            return new Permission($permission_model_instance->name);
        } catch (PermissionAlreadyExists $exception) {
            Log::error($exception->getMessage());
            throw new ServiceCallException("a permission named $attributes[name] already exists", code: ErrorCode::SQLDuplicateEntry->value, httpStatusCode: 400, context: [
                "name" => $attributes["name"]
            ]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage(), context: [
                "name" => $attributes["name"]
            ]);
            throw new ServiceCallException();
        }
    }
}
