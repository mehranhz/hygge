<?php

namespace App\DTO\Response\Blog;

use App\DTO\Response\BaseResponse;


class PostCreateResponse extends BaseResponse
{
    public int $id;
    public string $title;
    public string $body;
    public string $authorName;

    public function __construct(int $id,string $title, string $body, string $authorName)
    {
        $this->id = $id;
        $this->title = $title;
        $this->body = $body;
        $this->authorName = $authorName;
        parent::__construct();
    }
}
