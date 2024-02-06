<?php

namespace App\DTO;

class Pagination
{
    public function __construct(
        public $currentPage,
        public $from = 1,
        public $lastPage = null,
        public $perPage = null,
        public $to = 1,
        public $total = null
    )
    {
    }
}
