<?php

namespace App\Services\Contracts;


use App\DTO\Response\UserProfile\BaseProfileResponse;
use App\Exceptions\ServiceCallException;

interface UserProfileServiceInterface
{
    /**
     * @param int $userID
     * @return BaseProfileResponse
     * @throws ServiceCallException
     */
    public function getUsersBasicData(int $userID): BaseProfileResponse;
}
