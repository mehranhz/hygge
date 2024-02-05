<?php

namespace App\Repository\Eloquent;

use App\Exceptions\ErrorCode;
use App\Exceptions\RepositoryRecordCreationException;
use App\Repository\Paginatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Database\UniqueConstraintViolationException;

abstract class BaseRepository
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


    public function get(array $query=[]): array
    {
        $collection = $this->model->where($this->getFilters($query))->paginate(...$this->makePaginationParams($query))->toArray();

        // removing data from collection
        $data = $collection["data"];

        array_splice($collection,1,1);
         return [
             "data" => $data,
             "pagination" => $collection
         ];
    }
}
