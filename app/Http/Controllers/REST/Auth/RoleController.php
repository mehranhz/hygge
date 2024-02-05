<?php

namespace App\Http\Controllers\REST\Auth;

use App\Exceptions\ServiceCallException;
use App\Http\Controllers\APIController;
use App\Http\Requests\REST\RoleCreateRequest;
use App\Repository\Eloquent\RoleRepository;
use App\Services\Contracts\RoleCreateServiceInterface;
use App\Services\Contracts\RoleListInterface;
use App\Services\RoleListService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends APIController
{
    private RoleCreateServiceInterface $roleCreateService;

    private RoleListInterface $roleListService;

    /**
     * @param RoleCreateServiceInterface $roleCreateService
     */
    public function __construct(RoleCreateServiceInterface $roleCreateService, RoleListInterface $roleListService)
    {
        parent::__construct();
        $this->roleCreateService = $roleCreateService;
        $this->roleListService = $roleListService;
    }

    public function index(Request $request)
    {
        try {
            $rolesCollection = $this->roleListService->find($request->toArray());
            return $this->respond(data: $rolesCollection["data"], meta_data: $rolesCollection["pagination"]);
        } catch (ServiceCallException $exception) {
            return $this->respondFromServiceCallException($exception);
        }
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
