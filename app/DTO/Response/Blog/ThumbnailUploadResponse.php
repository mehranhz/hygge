<?php

namespace App\DTO\Response\Blog;

use App\DTO\Response\BaseResponse;

class ThumbnailUploadResponse extends BaseResponse
{
    public string $path;

    public function __construct($path)
    {
        $this->path = $path;
    }
}
