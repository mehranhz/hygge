<?php

namespace App\Http\Response;

interface ResponseContract
{
    public function setSuccess(bool $success);
    public function setData(array $data);
    public function setError(array $errors);
    public function setMessage(string $message);
    public function setErrorCode(int $error_code);
}
