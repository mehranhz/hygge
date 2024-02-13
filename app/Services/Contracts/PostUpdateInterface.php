<?php

namespace App\Services\Contracts;


use App\Exceptions\ServiceCallException;

interface PostUpdateInterface
{
    /**
     * @param int $id
     * @param array $attributes
     * @return bool
     * @throws ServiceCallException
     */
    public function update(int $id,array $attributes): bool;
}
