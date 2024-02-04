<?php

namespace App\Services\Contracts;

interface AuthenticationInterface
{
    /**
     * @param array $attributes
     * @return bool
     */
    public function authenticate(array $attributes): bool;
}
