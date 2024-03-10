<?php

namespace App\Services;

use App\DTO\PaginatedData;
use App\DTO\Response\BaseResponse;
use App\DTO\Response\Category\CategoryCreateResponse;
use App\DTO\Response\Category\CategoryResponse;
use App\Exceptions\RepositoryException;
use App\Exceptions\ServiceCallException;
use App\Repository\CategoryRepositoryInterface;
use App\Services\Contracts\CategoryServiceInterface;

class CategoryService implements CategoryServiceInterface
{
    protected CategoryRepositoryInterface $categoryRepository;

    /**
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param array $attributes
     * @return BaseResponse
     * @throws ServiceCallException
     */
    public function create(array $attributes): BaseResponse
    {
        try {
            $category = $this->categoryRepository->create(array_merge($attributes, [
                "user_id" => auth()->id()
            ]));
            return new CategoryCreateResponse(
                $category->getTitle(),
                $category->getDescription(),
                $category->getThumbnail(),
            );
        } catch (RepositoryException $exception) {
            throw new ServiceCallException($exception->getMessage());
        }
    }

    /**
     * @param int $id
     * @param array $attributes
     * @return bool
     * @throws ServiceCallException
     */
    public function update(int $id, array $attributes): bool
    {
        try {
            return $this->categoryRepository->update($id, $attributes);
        } catch (RepositoryException $exception) {
            throw new ServiceCallException($exception->getMessage());
        }
    }

    public function get(array $query): PaginatedData
    {
        try {
            return $this->categoryRepository->get($query);
        } catch (RepositoryException $exception) {
            throw new ServiceCallException($exception->getMessage());
        }
    }

    /**
     * @param int $id
     * @return bool
     * @throws ServiceCallException
     */
    public function delete(int $id): bool
    {
        try {
            return $this->categoryRepository->delete($id);
        } catch (RepositoryException $exception) {
            throw new ServiceCallException($exception->getMessage(), $exception->getCode());
        }
    }

    public function getByID(int $id): CategoryResponse
    {
        try {
            $category = $this->categoryRepository->getByID($id);
            return new CategoryResponse($category->getTitle(), $category->getDescription());
        } catch (RepositoryException $exception) {
            throw new ServiceCallException($exception->getMessage(), $exception->getCode());
        }
    }
}
