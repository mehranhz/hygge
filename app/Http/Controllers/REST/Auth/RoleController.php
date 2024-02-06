<?php

namespace App\Http\Controllers\REST\Auth;

use App\Exceptions\ServiceCallException;
use App\Http\Controllers\APIController;
use App\Http\Requests\REST\RoleCreateRequest;
use App\Services\Contracts\RoleCreateServiceInterface;
use App\Services\Contracts\RoleListInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends APIController
{
    private RoleCreateServiceInterface $roleCreateService;

    private RoleListInterface $roleListService;

    /**
     * @param RoleCreateServiceInterface $roleCreateService
     * @param RoleListInterface $roleListService
     */
    public function __construct(RoleCreateServiceInterface $roleCreateService, RoleListInterface $roleListService)
    {
        parent::__construct();
        $this->roleCreateService = $roleCreateService;
        $this->roleListService = $roleListService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $rolesCollection = $this->roleListService->find($request->toArray());
            return $this->respond(data: $rolesCollection->getData(), meta_data: $rolesCollection->getPaginationArray());
        } catch (ServiceCallException $exception) {
            return $this->respondFromServiceCallException($exception);
        }
    }

    /**
     * @param RoleCreateRequest $request
     * @return JsonResponse
     */
    public function create(RoleCreateRequest $request): JsonResponse
    {
        try {
            $role = $this->roleCreateService->create(['name' => $request->name]);
            return $this->createdSuccessfullyRespond(data: [
                'role' => $role->getName()
            ]);
        } catch (ServiceCallException $exception) {
            return $this->respondFromServiceCallException($exception);
        }
    }
}
