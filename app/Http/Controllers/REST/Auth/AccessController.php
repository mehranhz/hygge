<?php

namespace App\Http\Controllers\REST\Auth;

use App\Exceptions\ServiceCallException;
use App\Http\Controllers\APIController;
use App\Http\Requests\REST\RoleToUserAssignmentRequest;
use App\Services\Contracts\RoleAssignmentInterface;
use Illuminate\Http\JsonResponse;

class AccessController extends APIController
{
    private RoleAssignmentInterface $roleAssignmentService;


    /**
     * @param RoleAssignmentInterface $roleAssignmentService
     */
    public function __construct(RoleAssignmentInterface $roleAssignmentService)
    {
        parent::__construct();
        $this->roleAssignmentService = $roleAssignmentService;
    }

    /**
     * @param RoleToUserAssignmentRequest $request
     * @return JsonResponse
     */
    public function assignRoleToUser(RoleToUserAssignmentRequest $request):JsonResponse
    {
        try {
            $this->roleAssignmentService->assignRoleToUser($request->userID, $request->roleID);
            return $this->respond(message: "role have been assigned to user successfully.");
        } catch (ServiceCallException $exception) {
            return $this->respondFromServiceCallException($exception);
        }
    }
}
