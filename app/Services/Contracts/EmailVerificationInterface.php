<?php

namespace App\Services\Contracts;

interface EmailVerificationInterface
{
    public function generateTokenFromEmailAddress(string $email): string;

    public function persistToken(string $email, string $token);

    public function verifyEmail(string $token): mixed;

    public function getEmailVerificationPath(string $token):string;
}
