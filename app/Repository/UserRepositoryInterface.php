<?php

namespace App\Repository;

use App\Entity\User;
use Illuminate\Support\Collection;

interface UserRepositoryInterface extends EloquentRepositoryInterface
{
    /**
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @param string $email
     * @return User
     */
    public function findByEmail(string $email): User;

    public function updateVerificationDateByUserEmail(string $email,string $timestamp);
}
