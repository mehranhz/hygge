<?php

namespace App\Http\Controllers\REST\Blog;

use App\Exceptions\ErrorCode;
use App\Exceptions\ServiceCallException;
use App\Http\Controllers\APIController;
use App\Http\Requests\REST\PostCreateRequest;
use App\Services\Contracts\PostCreateInterface;
use App\Services\Contracts\PostUpdateInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends APIController
{
    private PostCreateInterface $postCreateService;
    private PostUpdateInterface $postUpdateService;

    /**
     * @param PostCreateInterface $postCreateService
     */
    public function __construct(PostCreateInterface $postCreateService, PostUpdateInterface $postUpdateService)
    {
        parent::__construct();
        $this->postCreateService = $postCreateService;
        $this->postUpdateService = $postUpdateService;
    }

    /**
     * @param PostCreateRequest $request
     * @return JsonResponse
     */
    public function store(PostCreateRequest $request): JsonResponse
    {
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
    public function update(int $id, Request $request): JsonResponse
    {
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
