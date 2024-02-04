<?php

namespace App\Http\Controllers;


use App\Exceptions\ServiceCallException;
use App\Http\Response\Response;
use Illuminate\Http\JsonResponse;


class APIController extends Controller
{
    protected Response $response;

    public function __construct()
    {
        $this->response = new Response();
    }

    private int $statusCode = 200;

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function setStatusCode(int $statusCode): APIController
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @param array $data
     * @param array $meta_data
     * @param array $headers
     * @param string|null $message
     * @param bool $success
     * @return JsonResponse
     */
    public function respond(array $data = [], array $meta_data = [], array $headers = [], string $message = "", $success = true): JsonResponse
    {
        $this->response->setSuccess($success);
        $this->response->setData($data);
        $this->response->setMetaData($meta_data);
        $this->response->setMessage($message);
        return $this->response->getJSON();
    }

    public function createdSuccessfullyRespond(array $data = [], string $message = "record inserted successfully!"): JsonResponse
    {
        $this->response->setHttpStatusCode(201);
        return $this->respond(data: $data, message: $message);

    }


    /**
     * @param string $message
     * @param int $error_code
     * @return JsonResponse
     */
    public function respondWithError(string $message, int $error_code = 0, int $http_status_code = 500): JsonResponse
    {
        $this->response->setMessage($message);
        $this->response->setErrorCode($error_code);
        $this->response->setSuccess(false);
        $this->response->setHttpStatusCode($http_status_code);
        return $this->response->getJSON();
    }

    public function respondNotFound(string $message = 'resource not found', $error_code = 0): JsonResponse
    {
        $this->response->setHttpStatusCode(404);
        return $this->respondWithError($message, $error_code);
    }

    /**
     * @param ServiceCallException $exception
     * @return JsonResponse
     */
    public function respondFromServiceCallException(ServiceCallException $exception): JsonResponse
    {
        $this->response->setMessage($exception->getMessage());
        $this->response->setErrorCode($exception->getCode());
        $this->response->setHttpStatusCode($exception->getHttpStatusCode());

        return $this->response->getJSON();
    }
}
