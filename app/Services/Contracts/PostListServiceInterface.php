<?php

namespace App\Services\Contracts;

use App\DTO\PaginatedData;

interface PostListServiceInterface
{
    public function find(array $query): PaginatedData;
}
