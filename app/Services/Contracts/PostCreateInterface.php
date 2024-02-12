<?php

namespace App\Services\Contracts;

use App\DTO\Response\Blog\PostCreateResponse;
use App\Entity\Post;

interface PostCreateInterface
{
    /**
     * @param array $attributes
     * @return PostCreateResponse
     */
    public function create(array $attributes): PostCreateResponse;
}
