<?php

namespace App\Http\Controllers\REST;

use App\Exceptions\ServiceCallException;
use App\Http\Controllers\APIController;
use App\Http\Requests\CategoryCreateRequest;
use App\Services\Contracts\CategoryServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends APIController
{
    protected CategoryServiceInterface $categoryService;

    public function __construct(CategoryServiceInterface $categoryService)
    {
        $this->categoryService = $categoryService;
        parent::__construct();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse{
        $categories = $this->categoryService->get($request->toArray());
        try {
            return $this->respond(
                data: $categories->getData(),
                meta_data: [
                    "pagination" => $categories->getPaginationArray()
                ]
            );
        }catch (ServiceCallException $exception){
            return $this->respondFromServiceCallException($exception);
        }
    }

    /**
     * @param CategoryCreateRequest $request
     * @return JsonResponse
     */
    public function store(CategoryCreateRequest $request): JsonResponse
    {
        try {
            return $this->createdSuccessfullyRespond(
                data: $this->categoryService->create($request->toArray())->toArray()
        );
        } catch (ServiceCallException $exception) {
            return $this->respondFromServiceCallException($exception);
        }
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse|void
     */
    public function update(Request $request, int $id){
        try {
            if ($this->categoryService->update($id,$request->toArray())){
                return $this->respond(
                    message: __("category updated successfully")
                );
            }
        }catch (ServiceCallException $exception){
            return $this->respondFromServiceCallException($exception);
        }
    }
}
