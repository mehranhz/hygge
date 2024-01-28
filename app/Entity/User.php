<?php

namespace App\Entity;

class User
{

    public function __construct(
        protected string $name,
        protected string $email,
        protected string $phone
    )
    {

    }
}
