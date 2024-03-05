<?php

namespace App\Http\Controllers\REST;

use App\Exceptions\ServiceCallException;
use App\Http\Controllers\APIController;
use App\Http\Requests\REST\FAQCreateRequest;
use App\Services\Contracts\FAQServiceInterface;
use Illuminate\Auth\Access\AuthorizationException;
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
     * @throws AuthorizationException
     */
    public function store(FAQCreateRequest $request): JsonResponse
    {
        $this->authorize('create faq');
        try {
            return $this->createdSuccessfullyRespond(
                data: $this->FAQService->create($request->toArray())->toArray()
            );
        } catch (ServiceCallException $exception) {
            return $this->respondFromServiceCallException($exception);
        }
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(Request $request, int $id)
    {
        $this->authorize('update faq');
        try {
            if ($this->FAQService->update($id, $request->toArray())) {
                return $this->respond(
                    message: __('FAQ updated successfully')
                );
            }
            throw new ServiceCallException("unknown error while trying to update faq");
        } catch (ServiceCallException $exception) {
            return $this->respondFromServiceCallException($exception);
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            if ($this->FAQService->delete($id)) {
                return $this->respond(
                    message: "faq deleted successfully."
                );
            }
            throw new ServiceCallException("unknown error while trying to delete faq with id $id");
        } catch (ServiceCallException $exception) {
            return $this->respondFromServiceCallException($exception);
        }
    }
}
