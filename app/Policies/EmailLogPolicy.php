<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EmailLog;

class EmailLogPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, EmailLog $emailLog): bool
    {
        // Admin can update any email log
        if ($user->role->slug === 'admin') {
            return true;
        }

        // Users can only update their own email logs
        return $user->id === $emailLog->sender_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, EmailLog $emailLog): bool
    {
        if ($user->role->slug === 'admin') {
            return true;
        }

        return $user->id === $emailLog->sender_id;
    }
}
