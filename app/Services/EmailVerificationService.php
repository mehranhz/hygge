<?php

namespace App\Services;

use App\Repository\EmailVerificationTokenRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Services\Contracts\EmailVerificationInterface;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Support\Facades\Hash;

class EmailVerificationService implements EmailVerificationInterface
{
    protected EmailVerificationTokenRepositoryInterface $tokenRepository;

    protected UserRepositoryInterface $userRepository;
    protected UserServiceInterface $userService;

    /**
     * @param EmailVerificationTokenRepositoryInterface $tokenRepository
     * @param UserRepositoryInterface $userRepository
     * @param UserServiceInterface $userService
     */
    public function __construct(EmailVerificationTokenRepositoryInterface $tokenRepository, UserRepositoryInterface $userRepository, UserServiceInterface $userService)
    {
        $this->tokenRepository = $tokenRepository;
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    /**
     * @param string $email
     * @return string
     */
    public function generateTokenFromEmailAddress(string $email): string
    {
        return md5($email . rand(0, 1000000));
    }

    /**
     * @param string $email
     * @param string $token
     * @return void
     */
    public function persistToken(string $email, string $token)
    {
        $this->tokenRepository->create([
            'email' => $email,
            'token' => $token
        ]);
    }

    /**
     * @param $token
     * @return bool
     * @throws \Exception
     */
    public function verifyEmail($token): bool
    {
        $stored_token = $this->tokenRepository->findByToken($token);
        $user = $this->userService->findByEmail($stored_token->email);

        if ($stored_token) {
            try {
                $this->userRepository->updateVerificationDateByUserEmail($user->getEmail(), now()->timestamp);
                return true;
            } catch (\Exception $exception) {
                throw new \Exception('failed to verify the account', 500);
            }
        }
        throw new \Exception('wrong token', 404);
    }

    /**
     * @param $token
     * @return string
     */
    public function getEmailVerificationPath($token): string
    {
        return route('verify_email', [
            'token' => $token
        ]);
    }
}
