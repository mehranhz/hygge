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
    public function create(array $attributes): mixed;

    /**
     * @param int $id
     * @param array $attributes
     * @return bool
     */
    public function update(int $id, array $attributes): bool;

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

    /**
     * @param Model $source
     * @return mixed
     */
    public function convert(Model $source): mixed;

    /**
     * @param int $id
     * @return mixed
     */
    public function getByID(int $id): mixed;
}
