<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserObserver
{
    public function creating(User $user)
    {
        if (request()->hasFile('avatar')) {
            $user->avatar = request()->file('avatar')->store('avatars', 'public');
        }
    }

    public function updating(User $user)
    {
        if (request()->hasFile('avatar')) {
            if ($user->getOriginal('avatar')) {
                Storage::disk('public')->delete($user->getOriginal('avatar'));
            }
            $user->avatar = request()->file('avatar')->store('avatars', 'public');
        }
    }
}
