<?php

namespace App\Exceptions;

use Illuminate\Support\Facades\Log;
use Throwable;

class RepositoryException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        Log::error($message);
        parent::__construct($message, $code, $previous);
    }
}
