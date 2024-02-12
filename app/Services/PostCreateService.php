<?php

namespace App\Services;

use App\DTO\Response\Blog\PostCreateResponse;
use App\Entity\Post;
use App\Exceptions\ErrorCode;
use App\Exceptions\ServiceCallException;
use App\Repository\PostRepositoryInterface;
use App\Services\Contracts\PostCreateInterface;
use Illuminate\Support\Facades\Log;

class PostCreateService implements PostCreateInterface
{
    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function create(array $attributes): PostCreateResponse
    {
        try {
            $post = $this->postRepository->create($attributes);
            return new PostCreateResponse($post->getTitle(), $post->getBody(), $post->getAuthor()->getName());
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            $message = $exception->getMessage();
            throw new ServiceCallException("failed to create new post: $message.", ErrorCode::Unknown->value, httpStatusCode: 500);
        }
    }
}
