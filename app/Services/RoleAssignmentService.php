<?php

namespace App\Services;

use App\Exceptions\ErrorCode;
use App\Exceptions\ServiceCallException;
use App\Repository\RoleRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Services\Contracts\RoleAssignmentInterface;
use Illuminate\Database\RecordsNotFoundException;


class RoleAssignmentService implements RoleAssignmentInterface
{
    private RoleRepositoryInterface $roleRepository;
    private UserRepositoryInterface $userRepository;

    /**
     * @param RoleRepositoryInterface $roleRepository
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(RoleRepositoryInterface $roleRepository, UserRepositoryInterface $userRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param int $userID
     * @param int $roleID
     * @return void
     * @throws ServiceCallException
     */
    public function assignRoleToUser(int $userID, int $roleID): void
    {
        try {
            $roleInstance = $this->roleRepository->find($roleID);
            $this->userRepository->assignRoleToUser($userID, $roleInstance->name);

        } catch (RecordsNotFoundException $exception) {
            throw new ServiceCallException($exception->getMessage(), code: ErrorCode::ResourceNotFound->value, httpStatusCode: 404);
        } catch (\Exception $exception) {
            throw new ServiceCallException($exception->getMessage(), code: ErrorCode::Unknown->value, httpStatusCode: 500);
        }
    }

}
