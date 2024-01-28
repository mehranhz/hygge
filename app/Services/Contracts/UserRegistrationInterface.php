<?php

namespace App\Services\Contracts;

use App\Entity\User;

interface UserRegistrationInterface
{
    public function create(array $attributes): User;
}
