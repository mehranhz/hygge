<?php

namespace App\Http\Controllers\REST\Auth;

use App\Exceptions\ServiceCallException;
use App\Http\Controllers\APIController;
use App\Http\Requests\CreateUserRequest;
use App\Services\Contracts\EmailVerificationInterface;
use App\Services\Contracts\UserRegistrationInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AuthController extends APIController
{
    private UserRegistrationInterface $userRegistrationService;
    private EmailVerificationInterface $emailVerificationService;

    /**
     * @param UserRegistrationInterface $userRegistration
     * @param EmailVerificationInterface $emailVerificationService
     */
    public function __construct(UserRegistrationInterface $userRegistration, EmailVerificationInterface $emailVerificationService)
    {
        parent::__construct();
        $this->userRegistrationService = $userRegistration;
        $this->emailVerificationService = $emailVerificationService;
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

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function verifyEmail(Request $request): RedirectResponse
    {
        try {
            if ($this->emailVerificationService->verifyEmail($request->token)) {
                $redirect_address = config('account.email_verification_success_redirect_address');
            } else {
                throw new \Exception('failed to verify email address');
            }
        } catch (\Exception $exception) {
            $redirect_address = config('account.email_verification_failure_redirect_address');
        }
        return redirect($redirect_address);
    }
}
