<?php

namespace App\Services\Contracts;

use App\DTO\Response\BaseResponse;
use Illuminate\Http\UploadedFile;

interface FilePersistInterface
{
    /**
     * @param mixed $file
     * @return BaseResponse
     */
    public function save(UploadedFile $file): BaseResponse;
}
