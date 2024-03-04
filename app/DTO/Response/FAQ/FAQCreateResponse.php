<?php

namespace App\DTO\Response\FAQ;

use App\DTO\Response\BaseResponse;

class FAQCreateResponse extends BaseResponse
{
    public function __construct(
        public string $title,
        public string $description,
        public bool $visibility = false
    )
    {
    }
}
