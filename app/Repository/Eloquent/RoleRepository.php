<?php

namespace App\Repository\Eloquent;


use App\Models\User;
use App\Repository\Paginatable;
use App\Repository\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    protected array $searchables = ['name'];

    public function __construct(Role $role)
    {
        parent::__construct($role);
    }

}
