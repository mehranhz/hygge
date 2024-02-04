<?php

namespace App\Http\Controllers;

use App\Services\Contracts\EmailVerificationInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private EmailVerificationInterface $emailVerificationService;

    /**
     * @param EmailVerificationInterface $emailVerificationService
     */
    public function __construct(EmailVerificationInterface $emailVerificationService)
    {
        $this->emailVerificationService = $emailVerificationService;
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
