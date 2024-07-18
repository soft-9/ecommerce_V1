<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can access the Filament dashboard.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function accessFilament(User $user)
    {
        return $user->admin;
    }
}
