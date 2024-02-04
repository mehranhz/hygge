<?php

namespace App\Exceptions;

use Throwable;

class ServiceCallException extends \Exception
{
    private int $httpStatusCode;

    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param int $httpStatusCode
     */
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null, int $httpStatusCode=500)
    {
        parent::__construct($message, $code, $previous);
        $this->httpStatusCode = $httpStatusCode;
    }

    /**
     * @return int
     */
    public function getHttpStatusCode(): int
    {
        return $this->httpStatusCode;
    }
}
