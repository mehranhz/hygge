<?php

namespace App\Services\Contracts;

use App\DTO\PaginatedData;
use App\DTO\Response\BaseResponse;

interface FAQServiceInterface
{
    public function create(array $attributes): BaseResponse;

    public function get(array $filters): PaginatedData;

    public function update(int $id,array $attributes): bool;

    public function delete(int $id):bool;
}
