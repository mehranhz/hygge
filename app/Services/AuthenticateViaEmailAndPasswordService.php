<?php

namespace App\Services;

use App\Exceptions\ErrorCode;
use App\Exceptions\ServiceCallException;
use App\Repository\UserRepositoryInterface;
use App\Services\Contracts\AuthenticationInterface;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Support\Facades\Hash;

class AuthenticateViaEmailAndPasswordService implements AuthenticationInterface
{
    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        protected UserRepositoryInterface $userRepository
    )
    {
    }

    /**
     * @param array $attributes
     * @return bool
     * @throws ServiceCallException
     */
    public function authenticate(array $attributes): bool
    {
        try {
            $user = $this->userRepository->findByEmail($attributes['email']);
            if ($user && Hash::check($attributes['password'], $user->getPassword())) {
                return true;
            }
            throw new ServiceCallException('there is no user with this credentials', ErrorCode::UserNotFound->value, httpStatusCode: 401);

        } catch (\Exception $exception) {
            throw new ServiceCallException('there is no user with this credentials', ErrorCode::UserNotFound->value, httpStatusCode: 401);
        }
    }
}
