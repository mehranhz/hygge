<?php

namespace App\Services\Contracts;


use App\Entity\Permission;

interface PermissionCreateInterface
{
    /**
     * @param array $attributes
     * @return Permission
     */
    public function create(array $attributes): Permission;
}
