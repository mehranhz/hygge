<?php

namespace App\Services;

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

    public function create(array $attributes): Post
    {
        try {
            $modeInstance = $this->postRepository->create($attributes);
            return new Post();
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw new ServiceCallException('failed to create new post.', ErrorCode::Unknown->value, httpStatusCode: 500);
        }
    }
}
