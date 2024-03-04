<?php

namespace App\Http\Controllers\REST\Auth;

use App\Exceptions\ServiceCallException;
use App\Http\Controllers\APIController;
use App\Http\Requests\REST\PermissionCreateRequest;
use App\Services\Contracts\PermissionCreateInterface;
use App\Services\Contracts\PermissionListInterface;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PermissionController extends APIController
{
    private PermissionCreateInterface $permissionCreateService;
    private PermissionListInterface $permissionListService;

    /**
     * @param PermissionCreateInterface $permissionCreateService
     * @param PermissionListInterface $permissionListService
     */
    public function __construct(PermissionCreateInterface $permissionCreateService, PermissionListInterface $permissionListService)
    {
        parent::__construct();
        $this->permissionCreateService = $permissionCreateService;
        $this->permissionListService = $permissionListService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $permissionsCollection = $this->permissionListService->find($request->toArray());

            return $this->respond(data: $permissionsCollection->getData(), meta_data: [
                "pagination" => $permissionsCollection->getPaginationArray()
            ]);
        } catch (ServiceCallException $exception) {
            return $this->respondFromServiceCallException($exception);
        }
    }

    /**
     * @param PermissionCreateRequest $request
     * @return JsonResponse
     */
    public function create(PermissionCreateRequest $request): JsonResponse
    {
        try {
            $permission = $this->permissionCreateService->create(["name" => $request->name]);
            return $this->createdSuccessfullyRespond(data: [
                "permission" => $permission->getName()
            ]);
        } catch (ServiceCallException $exception) {
            return $this->respondFromServiceCallException($exception);
        }
    }
}
