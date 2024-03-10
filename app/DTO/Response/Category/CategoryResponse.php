<?php

namespace App\DTO\Response\Category;

use App\DTO\Response\BaseResponse;

class CategoryResponse extends BaseResponse
{
    public function __construct(
        public string $title,
        public ?string $description
    )
    {

    }
}
