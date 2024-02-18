<?php

namespace App\Services;

use App\DTO\Response\UserProfile\BaseProfileResponse;
use App\Exceptions\RepositoryException;
use App\Exceptions\ServiceCallException;
use App\Repository\UserRepositoryInterface;
use App\Services\Contracts\UserProfileServiceInterface;

class UserProfileService implements UserProfileServiceInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param int $userID
     * @return BaseProfileResponse
     * @throws ServiceCallException
     */
    public function getUsersBasicData(int $userID): BaseProfileResponse
    {
        try {
            $user = $this->userRepository->getByID($userID);
            return new BaseProfileResponse(
                name: $user->getName(),
                email: $user->getEmail(),
                userName: $user->getEmail()
            );
        } catch (RepositoryException $exception) {
            throw new ServiceCallException();
        }
    }
}
