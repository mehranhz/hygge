<?php

namespace App\Services\Contracts;


use App\DTO\PaginatedData;
use App\Exceptions\ServiceCallException;

interface RoleListInterface
{
    /**
     * @param array $query
     * @return PaginatedData
     * @throws ServiceCallException
     */
    public function find(array $query): PaginatedData;
}
