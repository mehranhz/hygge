<?php

namespace App\Repository;

interface RoleRepositoryInterface extends EloquentRepositoryInterface
{
    /**
     * @param int $roleID
     * @param string $permissionName
     * @return void
     */
    public function givePermissionToRole(int $roleID, string $permissionName): void;
}
