<?php

namespace App\Http\Controllers\REST;

use App\Exceptions\ServiceCallException;
use App\Http\Controllers\APIController;
use App\Http\Requests\REST\FAQCreateRequest;
use App\Services\Contracts\FAQServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FAQController extends APIController
{
    protected FAQServiceInterface $FAQService;

    public function __construct(FAQServiceInterface $FAQService)
    {
        $this->FAQService = $FAQService;
        parent::__construct();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $faqs = $this->FAQService->get($request->toArray());
            return $this->respond(
                data: $faqs->getData(),
                meta_data: [
                    "pagination" => $faqs->getPaginationArray()
                ]
            );
        } catch (ServiceCallException $exception) {
            return $this->respondFromServiceCallException($exception);
        }
    }

    /**
     * @param FAQCreateRequest $request
     * @return JsonResponse
     */
    public function store(FAQCreateRequest $request): JsonResponse
    {
        try {
            return $this->createdSuccessfullyRespond(
                data: $this->FAQService->create($request->toArray())->toArray()
            );
        } catch (ServiceCallException $exception) {
            return $this->respondFromServiceCallException($exception);
        }
    }
}
