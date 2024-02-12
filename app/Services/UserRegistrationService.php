<?php

namespace App\Services;

use App\Entity\User;
use App\Events\UserSelfRegistered;
use App\Exceptions\RepositoryRecordCreationException;
use App\Exceptions\ServiceCallException;
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


    /**
     * @param array $attributes
     * @return User
     * @throws ServiceCallException
     */
    public function create(array $attributes): User
    {
        try {
            $user =  $this->userRepository->create($attributes);

            UserSelfRegistered::dispatch($user);
        } catch (RepositoryRecordCreationException $exception) {
            throw new ServiceCallException($exception->getMessage(), $exception->getCode(), httpStatusCode: 400);
        } catch (\Exception $exception) {

            throw new ServiceCallException($exception->getMessage(), $exception->getCode(), httpStatusCode: 500);
        }
        return $user;
    }
}
