<?php

namespace App\Services;

use App\DTO\PaginatedData;

use App\Exceptions\RepositoryException;
use App\Exceptions\ServiceCallException;
use App\Repository\PostRepositoryInterface;
use App\Services\Contracts\PostListServiceInterface;

class PostListService implements PostListServiceInterface
{
    private PostRepositoryInterface $postRepository;
    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function find(array $query): PaginatedData
    {
        try {
            return $this->postRepository->get($query);

        }catch (RepositoryException $exception){
            throw new ServiceCallException();
        }
    }
}
