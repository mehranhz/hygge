<?php

namespace App\DTO\Response\UserProfile;

use App\DTO\Response\BaseResponse;

class BaseProfileResponse extends BaseResponse
{
    public function __construct(
        public string      $name,
        public string      $email,
        public string      $userName,
        public string|null $role = null
    )
    {
    }
}
