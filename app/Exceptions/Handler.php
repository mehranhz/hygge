<?php

namespace App\Exceptions;

use App\Http\Response\Response;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * @var string[]
     */
    private array $validExceptions = [
        AuthorizationException::class,
        AuthenticationException::class,
        ServiceCallException::class,
        NotFoundHttpException::class,
        MethodNotAllowedHttpException::class
    ];

    /**
     * @var int[]
     */
    private array $httpStatusCode = [
        AuthorizationException::class => 403,
        AuthenticationException::class => 401,
        ServiceCallException::class => 500,
        NotFoundHttpException::class => 404,
        MethodNotAllowedHttpException::class => 405
    ];

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

    /**
     * @param Throwable $e
     * @return JsonResponse
     * @throws ServiceCallException
     * @throws Throwable
     */
    private function handleAPIException(Throwable $e): JsonResponse
    {
        Log::error($e->getMessage(), context: $e->getTrace());
        if (is_a($e, ServiceCallException::class)) {
            throw $e;
        }

        $response = new Response();
        $response->setSuccess(false);
        foreach ($this->validExceptions as $exceptionType) {
            if (is_a($e, $exceptionType)) {
                $response->setErrorCode($e->getCode());
                $response->setMessage($e->getMessage());
                $response->setHttpStatusCode($this->httpStatusCode[$exceptionType]);
                return $response->getJSON();
            }
        }
        $response->setHttpStatusCode(500);
        $response->setMessage('Something went wrong!.');
        $response->setErrorCode($e->getCode());

        return $response->getJSON();

    }

    /**
     * @param $request
     * @param Throwable $e
     * @return JsonResponse|Response|RedirectResponse
     * @throws ServiceCallException
     * @throws Throwable
     */
//    public function render($request, Throwable $e): JsonResponse|Response|RedirectResponse
//    {
//        if ($request->wantsJson()) {
//            return $this->handleAPIException($e);
//        }
//        return parent::render($request, $e);
//    }
}
