<?php

namespace App\Http\Requests;

use App\Http\Response\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class APIRequest extends FormRequest
{
    public function __construct()
    {
        parent::__construct();
        $this->response = new Response();
    }

    protected Response $response;

    /**
     * @param array $errors
     * @param int $error_code
     * @param string $message
     * @param int $http_status_code
     * @return JsonResponse
     */
    protected function structResponseError(mixed $errors, int $error_code = 422, string $message = "something went wrong", int $http_status_code = 500): JsonResponse
    {
        $this->response->setSuccess(false);
        $this->response->setMessage($message);
        $this->response->setErrorCode($error_code);
        $this->response->setError($errors);
        $this->response->setHttpStatusCode($http_status_code);

        return $this->response->getJSON();
    }

    /**
     * @param Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            $this->structResponseError(
                $validator->errors()->toArray(),
                error_code: 422,
                http_status_code: 400
            ));
    }

}
