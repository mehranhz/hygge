<?php

namespace App\Services\Contracts;



use App\Entity\User;

interface UserServiceInterface
{
    public function findByEmail(string $email): User;
}
