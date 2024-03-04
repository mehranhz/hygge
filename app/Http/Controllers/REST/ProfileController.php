<?php

namespace App\Http\Controllers\REST;

use App\Exceptions\ServiceCallException;
use App\Http\Controllers\APIController;
use App\Services\Contracts\UserProfileServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends APIController
{
    private UserProfileServiceInterface $userProfileService;

    public function __construct(UserProfileServiceInterface $userProfileService)
    {
        $this->userProfileService = $userProfileService;
        parent::__construct();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function myData(Request $request): JsonResponse
    {
        try {
            $userProfile = $this->userProfileService->getUsersBasicData(auth()->id());
            return $this->respond(data: $userProfile->toArray());
        } catch (ServiceCallException $exception) {
            return $this->respondFromServiceCallException($exception);
        }
    }
}
