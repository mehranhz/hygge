<?php

namespace App\DTO\Response\Blog;

use App\DTO\Response\BaseResponse;

class PostResponse extends BaseResponse
{

    public function __construct(
        public int    $id,
        public string $title,
        public string $body,
        public string|null $metaTitle,
        public string|null $metaDescription,
        public string|null $thumbnail,
        public int    $readTime,
        public string $authorName
    )
    {

    }
}
