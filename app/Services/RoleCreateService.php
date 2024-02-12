<?php

namespace App\Services;

use App\Entity\Role;
use App\Exceptions\ErrorCode;
use App\Exceptions\ServiceCallException;
use App\Repository\RoleRepositoryInterface;
use App\Services\Contracts\RoleCreateInterface;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Exceptions\RoleAlreadyExists;

class RoleCreateService implements RoleCreateInterface
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
     * @param array $attributes
     * @return Role
     * @throws ServiceCallException
     */
    public function create(array $attributes): Role
    {
        try {
            $role = $this->roleRepository->create(['name' => $attributes['name']]);
            return $role;
        } catch (RoleAlreadyExists  $exception) {
            Log::error($exception->getMessage());
            throw new ServiceCallException("a role named $attributes[name] already exists", code: ErrorCode::SQLDuplicateEntry->value, httpStatusCode: 400, context: [
                "attributes" => $attributes,
            ]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw new ServiceCallException('failed to create role', code: ErrorCode::Unknown->value, context: [
                "attributes" => $attributes,
            ]);
        }

    }
}
