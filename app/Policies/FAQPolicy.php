<?php

namespace App\Policies;

use App\Models\FAQ;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FAQPolicy
{

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, FAQ $fAQ): bool
    {
        return true;
    }
}
