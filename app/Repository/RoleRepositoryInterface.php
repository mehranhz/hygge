<?php

namespace App\Repository;

use App\Entity\Role;
use Illuminate\Database\Eloquent\Model;

interface RoleRepositoryInterface extends EloquentRepositoryInterface
{
    /**
     * @param int $roleID
     * @param string $permissionName
     * @return void
     */
    public function givePermissionToRole(int $roleID, string $permissionName): void;

    public function convert(Model $source): Role;
}
