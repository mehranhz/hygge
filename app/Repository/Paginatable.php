<?php

namespace App\Repository;

trait Paginatable
{
    /**
     * @param array $query
     * @return array
     */
    public function makePaginationParams(array $query): array
    {
        return [
            $query['perPage'] ?? 10,
            ['*'],
            'page',
            $query['pageNumber'] ?? 1
        ];
    }
}
