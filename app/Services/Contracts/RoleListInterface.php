<?php

namespace App\Services\Contracts;


use App\DTO\PaginatedData;

interface RoleListInterface
{
    /**
     * @param array $query
     * @return PaginatedData
     */
    public function find(array $query): PaginatedData;
}
