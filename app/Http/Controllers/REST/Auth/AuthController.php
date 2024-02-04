<?php

namespace App\Http\Controllers\REST\Auth;

use App\Exceptions\ServiceCallException;
use App\Http\Controllers\APIController;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\REST\LoginViaEmailAndPasswordRequest;
use App\Services\Contracts\AuthenticationInterface;
use App\Services\Contracts\UserRegistrationInterface;
use App\Services\Contracts\UserTokenGeneratorInterface;
use App\Services\SanctumTokenGenerator;
use Illuminate\Http\JsonResponse;


class AuthController extends APIController
{
    private UserRegistrationInterface $userRegistrationService;
    private AuthenticationInterface $authenticationService;

    private UserTokenGeneratorInterface $tokenGenerator;


    /**
     * @param UserRegistrationInterface $userRegistration
     * @param AuthenticationInterface $authenticationService
     */
    public function __construct(UserRegistrationInterface $userRegistration, AuthenticationInterface $authenticationService)
    {
        parent::__construct();
        $this->userRegistrationService = $userRegistration;
        $this->authenticationService = $authenticationService;
        $this->tokenGenerator = new SanctumTokenGenerator();
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
            $response = $this->respondFromServiceCallException($exception);
        }

        return $response;
    }

    /**
     * @param LoginViaEmailAndPasswordRequest $request
     * @return JsonResponse
     */
    public function loginViaEmailAndPassword(LoginViaEmailAndPasswordRequest $request): JsonResponse
    {
        try {

            $this->authenticationService->authenticate([
                'email' => $request->email,
                'password' => $request->password
            ]);

            $token = $this->tokenGenerator->generateToken([
                'email' => $request->email
            ]);

            $response = $this->respond(data: [
                'token' => $token
            ]);


        } catch (ServiceCallException $exception) {
            $response = $this->respondFromServiceCallException($exception);
        }

        return $response;
    }


}
