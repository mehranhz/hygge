<?php

namespace App\Http\Controllers\REST\Blog;

use App\Exceptions\ErrorCode;
use App\Exceptions\ServiceCallException;
use App\Http\Controllers\APIController;
use App\Http\Requests\REST\PostCreateRequest;
use App\Models\Post;
use App\Services\Contracts\PostCreateInterface;
use App\Services\Contracts\PostListServiceInterface;
use App\Services\Contracts\PostUpdateInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends APIController
{
    private PostCreateInterface $postCreateService;
    private PostUpdateInterface $postUpdateService;

    private PostListServiceInterface $postListService;

    /**
     * @param PostCreateInterface $postCreateService
     * @param PostUpdateInterface $postUpdateService
     * @param PostListServiceInterface $postListService
     */
    public function __construct(PostCreateInterface $postCreateService, PostUpdateInterface $postUpdateService, PostListServiceInterface $postListService)
    {
        parent::__construct();
        $this->postCreateService = $postCreateService;
        $this->postUpdateService = $postUpdateService;
        $this->postListService = $postListService;
    }


    public function index(Request $request): JsonResponse
    {
        $collection = $this->postListService->find($request->toArray());
        try {
            return $this->respond(data: $collection->getData(),meta_data: [
                "pagination" => $collection->getPaginationArray()
            ]);
        } catch (ServiceCallException $exception) {
            return $this->respondFromServiceCallException($exception);
        }
    }

    /**
     * @param PostCreateRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(PostCreateRequest $request): JsonResponse
    {

        $this->authorize('create post');
        try {
            $post = $this->postCreateService->create($request->toArray());
            return $this->createdSuccessfullyRespond(data: $post->toArray());
        } catch (ServiceCallException $exception) {
            return $this->respondFromServiceCallException($exception);
        }
    }

    /**
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update(int $id, Request $request)
    {
        Gate::authorize('update post');

        try {
            if ($this->postUpdateService->update($id, $request->toArray())) {
                return $this->respond(message: 'post updated successfully.');
            }
            throw new ServiceCallException('updating post failed.', ErrorCode::Unknown->value);
        } catch (ServiceCallException $exception) {
            return $this->respondFromServiceCallException($exception);
        }
    }
}
