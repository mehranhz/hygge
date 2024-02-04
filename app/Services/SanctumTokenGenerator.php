<?php

namespace App\Services;

use App\Exceptions\ErrorCode;
use App\Exceptions\ServiceCallException;
use App\Models\User;
use App\Repository\Eloquent\UserRepository;
use App\Services\Contracts\UserTokenGeneratorInterface;

class SanctumTokenGenerator implements UserTokenGeneratorInterface
{
    protected UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository(new User());
    }

    /**
     * @param array $attributes
     * @return string
     * @throws ServiceCallException
     */
    public function generateToken(array $attributes): string
    {
        try {
            return $this->generateSanctumToken($attributes['email']);
        } catch (\Exception $exception) {
            throw new ServiceCallException($exception->getMessage(), $exception->getCode(), httpStatusCode: 401);
        }
    }

    /**
     * @param string $email
     * @return string
     * @throws \Exception
     */
    protected function generateSanctumToken(string $email): string
    {
        $user = $this->userRepository->getModelInstanceByEmail($email);
        if ($user) {
            return $user->createToken('simple')->plainTextToken;
        }

        throw new \Exception('user not fround', ErrorCode::UserNotFound->value);
    }


}
