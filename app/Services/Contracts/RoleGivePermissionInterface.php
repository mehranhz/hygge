<?php

namespace App\Services\Contracts;

use App\Exceptions\ServiceCallException;

interface RoleGivePermissionInterface
{
    /**
     * @param int $roleID
     * @param int $permissionID
     * @return void
     * @throws ServiceCallException
     */
    public function givePermissionToRole(int $roleID, int $permissionID): void;
}
