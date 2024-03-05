<?php

namespace App\Services;

use App\Exceptions\RepositoryException;
use App\Exceptions\ServiceCallException;
use App\Repository\PostRepositoryInterface;
use App\Services\Contracts\PostDeleteServiceInterface;

class PostDeleteService implements PostDeleteServiceInterface
{
    protected PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }


    /**
     * @param int $id
     * @return bool
     * @throws ServiceCallException
     */
    public function delete(int $id): bool
    {
        try {
            return $this->postRepository->delete($id);
        } catch (RepositoryException $exception) {
            throw new ServiceCallException($exception->getMessage(), $exception->getCode(), httpStatusCode: $exception->getCode());
        }
    }
}
