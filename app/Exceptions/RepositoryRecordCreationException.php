<?php

namespace App\Exceptions;

class RepositoryRecordCreationException extends BaseException
{
    private array $errors;

    public function __construct(string $message, string $model = "record", int $code = 0)
    {

        parent::__construct("Error while creating $model" . ", $message.", $code);
    }

}
