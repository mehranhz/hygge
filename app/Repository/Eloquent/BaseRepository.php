<?php

namespace App\Repository\Eloquent;

use App\DTO\PaginatedData;
use App\Exceptions\ErrorCode;
use App\Exceptions\RepositoryException;
use App\Exceptions\RepositoryRecordCreationException;
use App\Repository\EloquentRepositoryInterface;
use App\Repository\Paginatable;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

abstract class BaseRepository implements EloquentRepositoryInterface
{
    use Paginatable;

    protected Model $model;
    /**
     * @var array
     */
    protected array $searchables = [];

    /**
     * @var array
     */
    protected array $updateable = [];

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
    public function create(array $attributes): mixed
    {
        try {
            $instance = $this->model->create($attributes);
            if (method_exists($this, 'convert')) {
                return $this->convert($instance);
            }

        } catch (UniqueConstraintViolationException $exception) {
            throw new RepositoryRecordCreationException(message: "duplicate entry", model: class_basename($this->model), code: ErrorCode::SQLDuplicateEntry->value);
        } catch (QueryException $exception) {
            throw new RepositoryRecordCreationException(message: $exception->getMessage(), model: class_basename($this->model), code: ErrorCode::Unknown->value);
        } catch (\Exception $exception) {
            throw new RepositoryException($exception->getMessage());
        }

        return $instance;
    }


    /**
     * @param int $id
     * @param array $attributes
     * @return bool
     * @throws AuthorizationException
     */
    public function update(int $id, array $attributes): bool
    {
        $instance = $this->find($id);
        if (!Gate::allows('update', $instance)) {
            throw new AuthorizationException('action is unauthorized', code: 403);
        }

        $updateAttributes = [];
        foreach ($attributes as $key => $value) {
            if (in_array($key, $this->updateable)) {
                $updateAttributes[$key] = $value;
            } else {

                Log::warning("trying to update property $key when its not defined as an update-able property.", context: [
                    "repository" => get_class($this),
                    "method" => "update"
                ]);
            }
        }

        return $instance->update($updateAttributes);
    }

    /**
     * @param $id
     * @return Model|null
     * @throws RepositoryException
     */
    public function find($id): ?Model
    {
        $instance = $this->model->find($id);
        if ($instance === null) {
            $className = $this->getModelName();
            throw new RepositoryException("there is no $className with provided id:$id", code: 404);
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

    /**
     * @param int $id
     * @return mixed
     * @throws \Exception
     */
    public function getByID(int $id): mixed
    {
        try {
            $instance = $this->find($id);
            if (method_exists($this, 'convert')) {
                return $this->convert($instance);
            }
            return $instance;
        } catch (\Exception $exception) {
            throw new RepositoryException(previous: $exception);
        }
    }

    /**
     * @param int $id
     * @return bool|null
     * @throws RepositoryException
     */
    public function delete(int $id): bool
    {
        $instance = $this->find($id);
        if ($instance) {
            return $instance->delete();
        }
        throw new RepositoryException("there is no record with id $id.",404);
    }
}
