<?php

namespace App\Repository\Eloquent;


use App\Repository\PermissionRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    protected array $searchables = ['name'];

    public function __construct(Permission $model)
    {
        parent::__construct($model);
    }
}
