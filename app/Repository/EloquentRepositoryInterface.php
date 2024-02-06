<?php

namespace App\Repository;

use App\DTO\PaginatedData;
use Illuminate\Database\Eloquent\Model;

interface EloquentRepositoryInterface
{
    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model;

    /**
     * @param int $id
     * @return Model|null
     */
    public function find(int $id): ?Model;

    /**
     * @param array $query
     * @return PaginatedData
     */
    public function get(array $query): PaginatedData;

    /**
     * @return string
     */
    public function getModelName(): string;
}
