<?php

namespace App\Http\Response;


use Illuminate\Http\JsonResponse;

abstract class BaseResponse implements ResponseContract
{


    public function __construct(
        protected bool   $success = false,
        protected string $message = '',
        protected array  $data = [],
        protected int    $errorCode = 0,
        protected array  $errors = [],
        protected array  $metaData = [],
        protected int    $httpStatusCode = 200
    )
    {

    }

    /**
     * @param array $data
     * @return BaseResponse
     */
    public function setData(array $data): BaseResponse
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param bool $success
     * @return $this
     */
    public function setSuccess(bool $success): BaseResponse
    {
        $this->success = $success;

        return $this;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage(string $message): BaseResponse
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @param int $error_code
     * @return $this
     */
    public function setErrorCode(int $error_code): BaseResponse
    {
        $this->errorCode = $error_code;

        return $this;
    }

    /**
     * @param array $errors
     * @return $this
     */
    public function setError(array $errors): BaseResponse
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * @param array $meta_data
     * @return $this
     */
    public function setMetaData(array $meta_data): BaseResponse
    {
        $this->metaData = $meta_data;

        return $this;
    }

    /**
     * @param int $httpStatusCode
     * @return void
     */
    public function setHttpStatusCode(int $httpStatusCode): void
    {
        $this->httpStatusCode = $httpStatusCode;
    }

    /**
     * @return JsonResponse
     */
    public function getJSON(): JsonResponse
    {
        $response = [
            "success" => $this->success,
            "data" => $this->data,
            "meta_data" => $this->metaData,
            "message" => $this->message,
            "error" => [
                "error_code" => $this->errorCode,
                "errors" => $this->errors
            ]
        ];
        return response()->json($response, $this->httpStatusCode);
    }
}
