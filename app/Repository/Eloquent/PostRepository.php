<?php

namespace App\Repository\Eloquent;


use App\DTO\PaginatedData;
use App\Entity\User;
use App\Models\Post;
use App\Repository\PostRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    protected array $updateable = ["title", "body"];

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

    /**
     * @param array $query
     * @return PaginatedData
     */
    public function get(array $query = []): PaginatedData
    {
        $collection = $this->model->with('user')->where($this->getFilters($query))->orderBy('created_at','DESC')->paginate(...$this->makePaginationParams($query));


        $posts = array_map(function ($post) {
            return [
                "id" => $post->id,
                "title" => $post->title,
                "body" => $post->body,
                "thumbnail" => $post->thumbnail,
                "meta_description" => $post->meta_description,
                "meta_title" => $post->meta_title,
                "author" => $post->user->name
            ];
        }, $collection->items());

        $collection = $collection->toArray();

        // removing data from collection
        array_splice($collection, 1, 1);

        return new PaginatedData($posts, $collection);

    }
}
