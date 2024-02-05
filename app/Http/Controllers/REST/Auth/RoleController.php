<?php

namespace App\Http\Controllers\REST\Auth;

use App\Exceptions\ServiceCallException;
use App\Http\Controllers\APIController;
use App\Http\Controllers\Controller;
use App\Http\Requests\REST\RoleCreateRequest;
use App\Services\Contracts\RoleCreateServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends APIController
{
    private RoleCreateServiceInterface $roleCreateService;

    /**
     * @param RoleCreateServiceInterface $roleCreateService
     */
    public function __construct(RoleCreateServiceInterface $roleCreateService)
    {
        parent::__construct();
        $this->roleCreateService = $roleCreateService;
    }

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
