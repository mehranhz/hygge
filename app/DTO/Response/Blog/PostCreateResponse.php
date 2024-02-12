<?php

namespace App\DTO\Response\Blog;

use App\DTO\Response\BaseResponse;


class PostCreateResponse extends BaseResponse
{
    public string $title;
    public string $body;
    public string $authorName;

    public function __construct(string $title, string $body, string $authorName)
    {
        $this->title = $title;
        $this->body = $body;
        $this->authorName = $authorName;
        parent::__construct();
    }
}
