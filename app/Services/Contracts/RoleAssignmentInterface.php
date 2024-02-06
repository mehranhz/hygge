<?php

namespace App\Services\Contracts;

use App\Exceptions\ServiceCallException;

interface RoleAssignmentInterface
{
    /**
     * @param int $userID
     * @param int $roleID
     * @return void
     * @throws ServiceCallException
     */
    public function assignRoleToUser(int $userID, int $roleID): void;
}
