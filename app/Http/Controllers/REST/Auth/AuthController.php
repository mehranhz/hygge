<?php

namespace App\Http\Controllers\REST\Auth;

use App\Http\Controllers\APIController;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Repository\UserRepositoryInterface;
use App\Services\Contracts\UserRegistrationInterface;
use Illuminate\Http\Request;

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

    public function selfRegister(CreateUserRequest $request)
    {
        try {
            $user = $this->userRegistrationService->create($request->toArray());
        }catch (\Exception $exception){
            return $this->respondWithError($exception->getMessage(),error_code: $exception->getCode());
        }

        return $this->createdSuccessfullyRespond(data: (array)$user);
    }
}
