<?php

namespace App\Entity;

use Illuminate\Notifications\Notifiable;

class User
{
    use Notifiable;

    public function __construct(
        protected string      $name,
        public string         $email,
        protected string      $phone,
        protected string|null $verificationDate = null,
        protected string|null $password = null,
    )
    {

    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getVerificationDate(): string|null
    {
        return $this->verificationDate;
    }

    public function getPassword():string|null
    {
        return $this->password;
    }
}
