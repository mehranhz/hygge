<?php

namespace App\Http\Controllers\REST\Auth;

use App\Exceptions\ServiceCallException;
use App\Http\Controllers\APIController;
use App\Http\Requests\REST\PermissionCreateRequest;
use App\Services\Contracts\PermissionCreateInterface;
use Illuminate\Http\JsonResponse;

class PermissionController extends APIController
{
    private PermissionCreateInterface $permissionCreateService;

    /**
     * @param PermissionCreateInterface $permissionCreateService
     */
    public function __construct(PermissionCreateInterface $permissionCreateService)
    {
        parent::__construct();
        $this->permissionCreateService = $permissionCreateService;
    }

    /**
     * @param PermissionCreateRequest $request
     * @return JsonResponse
     */
    public function create(PermissionCreateRequest $request)
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
