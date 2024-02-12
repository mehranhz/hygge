<?php

namespace App\Http\Controllers\REST\Blog;

use App\Exceptions\ServiceCallException;
use App\Http\Controllers\APIController;
use App\Http\Requests\REST\PostCreateRequest;
use App\Services\Contracts\PostCreateInterface;
use Illuminate\Http\JsonResponse;

class PostController extends APIController
{
    private PostCreateInterface $postCreateService;

    /**
     * @param PostCreateInterface $postCreateService
     */
    public function __construct(PostCreateInterface $postCreateService)
    {
        parent::__construct();
        $this->postCreateService = $postCreateService;
    }

    /**
     * @param PostCreateRequest $request
     * @return JsonResponse|void
     */
    public function store(PostCreateRequest $request)
    {
        try {
            $post = $this->postCreateService->create($request->toArray());
            return $this->createdSuccessfullyRespond(data: $post->toArray());
        } catch (ServiceCallException $exception) {
            return $this->respondFromServiceCallException($exception);
        }
    }
}
