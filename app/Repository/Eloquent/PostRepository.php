<?php

namespace App\Repository\Eloquent;


use App\Models\Post;
use Illuminate\Database\Eloquent\Model;

class PostRepository extends BaseRepository
{
    /**
     * @param Post $model
     */
    public function __construct(Post $model)
    {
        parent::__construct($model);
    }

    public function create(array $attributes): Model
    {
        return auth()->user()->posts->create($attributes);
    }
}
