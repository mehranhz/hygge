<?php

namespace App\Services\Contracts;


use App\DTO\PaginatedData;
use App\DTO\Response\BaseResponseInterface;

interface CategoryServiceInterface
{
    public function create(array $attributes): BaseResponseInterface;

    public function update(int $id, array $attributes): bool;

    public function get(array $query): PaginatedData;

    public function delete(int $id): bool;
}
