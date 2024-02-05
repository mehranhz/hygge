<?php

namespace App\Services\Contracts;


interface RoleListInterface
{
    /**
     * @param array $query
     * @return array
     */
    public function find(array $query): array;
}
