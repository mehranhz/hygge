<?php

namespace App\Repository\Eloquent;

use App\DTO\PaginatedData;
use App\Exceptions\ErrorCode;
use App\Exceptions\RepositoryRecordCreationException;
use App\Repository\EloquentRepositoryInterface;
use App\Repository\Paginatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Database\UniqueConstraintViolationException;

abstract class BaseRepository implements EloquentRepositoryInterface
{
    use Paginatable;

    protected Model $model;
    protected array $searchables = [];

    /**
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }


    /**
     * @return string
     */
    public function getModelName(): string
    {
        return class_basename($this->model);
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
        $instance =  $this->model->find($id);
        if ($instance === null){
            $className= $this->getModelName();
            throw new RecordsNotFoundException("there is no $className with provided id:$id",code: 404);
        }

        return $instance;
    }

    protected function getFilters(array $query)
    {
        $searchables = [];
        foreach ($query as $filterKey => $filterValue) {
            if (in_array($filterKey, $this->searchables)) {
                $searchables[$filterKey] = $filterValue;
            }
        }

        return $searchables;
    }


    /**
     * @param array $query
     * @return PaginatedData
     */
    public function get(array $query = []): PaginatedData
    {
        $collection = $this->model->where($this->getFilters($query))->paginate(...$this->makePaginationParams($query))->toArray();
        $data = $collection["data"];

        // removing data from collection
        array_splice($collection, 1, 1);

        return new PaginatedData($data, $collection);

    }
}
