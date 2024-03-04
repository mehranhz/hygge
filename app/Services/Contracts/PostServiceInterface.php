<?php

namespace App\Services\Contracts;

use App\DTO\Response\Blog\PostResponse;

interface PostServiceInterface
{
    public function findByID(int $ID): PostResponse;
}
