<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

interface EmailVerificationTokenRepositoryInterface extends EloquentRepositoryInterface
{
    /**
     * @param string $token
     * @return mixed
     */
    public function findByToken(string $token);
}
