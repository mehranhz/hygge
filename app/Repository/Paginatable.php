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
            $query['pageSize'] ?? 10,
            ['*'],
            'page',
            $query['page'] ?? 1
        ];
    }
}
