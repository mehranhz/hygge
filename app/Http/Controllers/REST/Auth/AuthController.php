<?php

namespace App\Http\Controllers\REST\Auth;

use App\Exceptions\ServiceCallException;
use App\Http\Controllers\APIController;
use App\Http\Requests\CreateUserRequest;
use App\Services\Contracts\UserRegistrationInterface;
use Illuminate\Http\JsonResponse;


class AuthController extends APIController
{
    private UserRegistrationInterface $userRegistrationService;


    /**
     * @param UserRegistrationInterface $userRegistration
     */
    public function __construct(UserRegistrationInterface $userRegistration)
    {
        parent::__construct();
        $this->userRegistrationService = $userRegistration;
    }

    /**
     * @param CreateUserRequest $request
     * @return JsonResponse
     */
    public function selfRegister(CreateUserRequest $request): JsonResponse
    {
        try {
            $user = $this->userRegistrationService->create($request->toArray());
            $response = $this->createdSuccessfullyRespond(data: (array)$user);
        } catch (ServiceCallException $exception) {
            $response = $this->respondWithError($exception->getMessage(), error_code: $exception->getCode(), http_status_code: $exception->getHttpStatusCode());
        }

        return $response;
    }


}
