<?php

namespace App\Services\Contracts;

use App\Entity\Role;
use App\Exceptions\ServiceCallException;

interface RoleCreateInterface
{
    /**
     * @param array $attributes
     * @return Role
     * @throws ServiceCallException
     */
    public function create(array $attributes): Role;
}
