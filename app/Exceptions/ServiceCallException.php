<?php

namespace App\Exceptions;

use Illuminate\Support\Facades\Log;
use Throwable;

class ServiceCallException extends \Exception
{
    private int $httpStatusCode;

    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param int $httpStatusCode
     * @param array $context context is used to provide more info for logging - do not pass any confidential data
     */
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null, int $httpStatusCode = 500, array $context = [])
    {
        parent::__construct($message, $code, $previous);
        $this->httpStatusCode = $httpStatusCode;

        Log::error($message,context: $context);
    }

    /**
     * @return int
     */
    public function getHttpStatusCode(): int
    {
        return $this->httpStatusCode;
    }
}
