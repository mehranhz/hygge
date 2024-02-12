<?php

namespace App\Repository;


use App\Entity\Post;
use Illuminate\Database\Eloquent\Model;

interface PostRepositoryInterface extends EloquentRepositoryInterface
{
    public function create(array $attributes): Post;

    public function convert(Model $source): Post;
}
