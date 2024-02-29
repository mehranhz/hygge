<?php

namespace App\Services;

use App\DTO\Response\Blog\PostResponse;
use App\Exceptions\RepositoryException;
use App\Exceptions\ServiceCallException;
use App\Repository\PostRepositoryInterface;
use App\Services\Contracts\PostServiceInterface;

class PostService implements PostServiceInterface
{
    public PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function findByID(int $ID): PostResponse
    {
        try {
            $post = $this->postRepository->getByID($ID);
            return new PostResponse(
                $post->getID(),
                $post->getTitle(),
                $post->getBody(),
                $post->getMetaTitle(),
                $post->getMetaDescription(),
                $post->getThumbnailFullPath(),
                $post->getReadTime(),
                $post->getAuthor()->getName()
            );
        } catch (RepositoryException $exception) {
            throw new ServiceCallException($exception->getMessage());
        }
    }

}
