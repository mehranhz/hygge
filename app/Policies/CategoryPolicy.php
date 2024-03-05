<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{

    /**
     * @param User $user
     * @param Category $category
     * @return bool
     */
    public function update(User $user, Category $category): bool
    {
        return $user->id === $category->user_id;
    }

}
