<?php

namespace App\Repository\Eloquent;


use App\Models\User;
use App\Repository\Paginatable;
use App\Repository\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    protected array $searchables = ['name'];

    /**
     * @param Role $role
     */
    public function __construct(Role $role)
    {
        parent::__construct($role);
    }

    /**
     * @param int $roleID
     * @param string $permissionName
     * @return void
     */
    public function givePermissionToRole(int $roleID, string $permissionName): void
    {
        $role = $this->find($roleID);
        $role->givePermissionTo($permissionName);
    }

    /**
     * @param Model $source
     * @return \App\Entity\Role
     */
    public function convert(Model $source): \App\Entity\Role
    {
        return new \App\Entity\Role($source->name);
    }
}
