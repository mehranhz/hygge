<?php

namespace App\Repository\Eloquent;


use App\Models\Post;
use App\Repository\PostRepositoryInterface;
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

    /**
     * @param Model $source
     * @return \App\Entity\Post
     */
    public function convert(Model $source): \App\Entity\Post
    {
        return new \App\Entity\Post($source->title,
            $source->body,
            $source->thumbnail,
            $source->meta_description,
            $source->meta_title,
            $source->user->name);
    }
}
