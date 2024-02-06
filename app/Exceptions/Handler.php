<?php

namespace App\Exceptions;

use App\Http\Response\Response;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    private function handleAPIException(Throwable $e)
    {
        $response = new Response();
        $response->setSuccess(false);
        if (is_a($e, AuthorizationException::class)) {
            $response->setHttpStatusCode(403);
            $response->setErrorCode(403);
            $response->setMessage('Action is unauthorized.');

        }else{
            $response->setHttpStatusCode(500);
            $response->setMessage('Something went wrong!.');
            $response->setErrorCode($e->getCode());
        }

        return $response->getJSON();
    }

    public function render($request, Throwable $e)
    {
        if ($request->wantsJson()) {
            return $this->handleAPIException($e);
        }
        return parent::render($request, $e);
    }
}
