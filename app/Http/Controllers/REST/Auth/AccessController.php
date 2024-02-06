<?php

namespace App\Http\Controllers\REST\Auth;

use App\Exceptions\ServiceCallException;
use App\Http\Controllers\APIController;
use App\Http\Requests\REST\GivePermissionToRoleRequest;
use App\Http\Requests\REST\RoleToUserAssignmentRequest;
use App\Services\Contracts\RoleAssignmentInterface;
use App\Services\Contracts\RoleGivePermissionInterface;
use Illuminate\Http\JsonResponse;

class AccessController extends APIController
{
    private RoleAssignmentInterface $roleAssignmentService;
    private RoleGivePermissionInterface $roleGivePermissionService;


    /**
     * @param RoleAssignmentInterface $roleAssignmentService
     * @param RoleGivePermissionInterface $roleGivePermissionService
     */
    public function __construct(RoleAssignmentInterface $roleAssignmentService, RoleGivePermissionInterface $roleGivePermissionService)
    {
        parent::__construct();
        $this->roleAssignmentService = $roleAssignmentService;
        $this->roleGivePermissionService = $roleGivePermissionService;
    }

    /**
     * @param RoleToUserAssignmentRequest $request
     * @return JsonResponse
     */
    public function assignRoleToUser(RoleToUserAssignmentRequest $request): JsonResponse
    {
        try {
            $this->roleAssignmentService->assignRoleToUser($request->userID, $request->roleID);
            return $this->respond(message: "role have been assigned to user successfully.");
        } catch (ServiceCallException $exception) {
            return $this->respondFromServiceCallException($exception);
        }
    }

    /**
     * @param GivePermissionToRoleRequest $request
     * @return JsonResponse
     */
    public function givePermissionToRole(GivePermissionToRoleRequest $request): JsonResponse
    {
//        $this->authorize('create permission');

        try {
            $this->roleGivePermissionService->givePermissionToRole($request->roleID, $request->permissionID);
            return $this->respond(message: "permission have been successfully assigned to role");
        } catch (ServiceCallException $exception) {
            return $this->respondFromServiceCallException($exception);
        }
    }
}
