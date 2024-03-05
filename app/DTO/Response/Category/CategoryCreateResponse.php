<?php

namespace App\DTO\Response\Category;

use App\DTO\Response\BaseResponse;

class CategoryCreateResponse extends BaseResponse
{
    public function __construct(
        protected string  $title,
        protected ?string $description = null,
        protected ?string $thumbnail = null,
    )
    {
    }
}
