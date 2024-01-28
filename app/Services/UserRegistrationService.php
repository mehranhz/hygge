<?php

namespace App\Services;

use App\Entity\User;
use App\Exceptions\RepositoryRecordCreationException;
use App\Repository\UserRepositoryInterface;
use App\Services\Contracts\UserRegistrationInterface;

class UserRegistrationService implements UserRegistrationInterface
{
    private UserRepositoryInterface $userRepository;

    /**
     * @param UserRepositoryInterface $userRepository
     * @return void
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function create(array $attributes): User
    {
        try {
            $newUSer = $this->userRepository->create($attributes);
        } catch (RepositoryRecordCreationException $exception) {
            throw new \Exception($exception->getMessage(), $exception->getCode());
        }
        return new User(
            $newUSer->name,
            $newUSer->email,
            $newUSer->phone
        );
    }
}
