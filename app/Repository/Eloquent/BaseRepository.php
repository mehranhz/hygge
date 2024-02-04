<?php

namespace App\Repository\Eloquent;

use App\Exceptions\ErrorCode;
use App\Exceptions\RepositoryRecordCreationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Database\UniqueConstraintViolationException;

abstract class BaseRepository
{
    protected Model $model;

    /**
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $attributes
     *
     * @return Model
     * @throws RepositoryRecordCreationException
     */
    public function create(array $attributes): Model
    {
        try {
            $instance = $this->model->create($attributes);
        } catch (UniqueConstraintViolationException $exception) {
            throw new RepositoryRecordCreationException(message: "duplicate entry", model: class_basename($this->model), code: ErrorCode::SQLDuplicateEntry->value);
        } catch (QueryException $exception) {
            throw new RepositoryRecordCreationException(message: "unknown", model: class_basename($this->model), code: ErrorCode::Unknown->value);
        }

        return $instance;
    }

    /**
     * @param $id
     * @return Model|null
     */
    public function find($id): ?Model
    {
        return $this->model->find($id);
    }
}
