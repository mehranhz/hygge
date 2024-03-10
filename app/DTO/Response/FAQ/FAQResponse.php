<?php

namespace App\DTO\Response\FAQ;

use App\DTO\Response\BaseResponse;

class FAQResponse extends BaseResponse
{
    public function __construct(
        public string $title,
        public string $description,
        public bool $visibility,
    )
    {
    }
}
