<?php

namespace App\Repository\Eloquent;


use App\Entity\User;
use App\Models\Post;
use App\Repository\PostRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    /**
     * @param Post $model
     */
    public function __construct(Post $model)
    {
        parent::__construct($model);
    }

    /**
     * @param array $attributes
     * @return \App\Entity\Post
     */
    public function create(array $attributes): \App\Entity\Post
    {
        $postInstance = auth()->user()->posts()->create($attributes);
        return $this->convert($postInstance);
    }

    /**
     * @param Model $source
     * @return \App\Entity\Post
     */
    public function convert(Model $source): \App\Entity\Post
    {
        return new \App\Entity\Post(
            $source->id,
            $source->title,
            $source->body,
            $source->thumbnail,
            $source->meta_description,
            $source->meta_title,
            new User(
                $source->user->name,
                $source->user->email,
            )
        );
    }
}
