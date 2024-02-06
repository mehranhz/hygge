<?php

namespace App\Http\Controllers\REST\Auth;

use App\Exceptions\ServiceCallException;
use App\Http\Controllers\APIController;
use App\Http\Requests\REST\PermissionCreateRequest;
use App\Services\Contracts\PermissionCreateInterface;

class PermissionController extends APIController
{
    private PermissionCreateInterface $permissionCreateService;

    public function __construct(PermissionCreateInterface $permissionCreateService)
    {
        parent::__construct();
        $this->permissionCreateService = $permissionCreateService;
    }

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
