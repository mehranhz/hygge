<?php

namespace App\Services\Contracts;

interface PostDeleteServiceInterface
{
    public function delete(int $id): bool;
}
