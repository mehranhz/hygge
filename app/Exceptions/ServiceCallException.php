<?php

namespace App\Exceptions;

use Illuminate\Support\Facades\Log;
use Throwable;

class ServiceCallException extends \Exception
{
    private int $httpStatusCode;

    private $validErrorCodesAsHttpStatusCode = [
        404,
        401,
        403,
        400
    ];

    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param int|null $httpStatusCode
     * @param array $context context is used to provide more info for logging - do not pass any confidential data
     */
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null, ?int $httpStatusCode = null, array $context = [])
    {
        parent::__construct($message, $code, $previous);
        if ($httpStatusCode === null && in_array($code, $this->validErrorCodesAsHttpStatusCode)) {
            $this->httpStatusCode = $code;
        } else {
            $this->httpStatusCode = $httpStatusCode === null ? 500 : $httpStatusCode;
        }

        Log::error($message, context: $context);
        Log::error("trace:", context: $this->getTrace());
    }

    /**
     * @return int
     */
    public function getHttpStatusCode(): int
    {
        return $this->httpStatusCode;
    }
}
