<?php

namespace App\Services\Contracts;

interface UserTokenGeneratorInterface
{
    public function generateToken(array $attributes):string;
}
