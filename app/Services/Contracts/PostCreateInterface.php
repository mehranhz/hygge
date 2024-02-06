<?php

namespace App\Services\Contracts;

use App\Entity\Post;

interface PostCreateInterface
{
    /**
     * @param array $attributes
     * @return Post
     */
    public function create(array $attributes): Post;
}
