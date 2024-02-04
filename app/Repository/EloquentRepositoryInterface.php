<?php

namespace App\Repository;

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
}
