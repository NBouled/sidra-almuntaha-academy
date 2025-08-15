<?php

namespace App\Observers;

use App\Enums\UserRole;
use App\Models\user;

class UserObserver
{


    /**
     * Handle the user "created" event.
     */
    public function created(user $user): void
    {
        if($user->role === UserRole::CUSTOMER){
            $user->customer()->create([]);

        }
    }

    /**
     * Handle the user "updated" event.
     */
    public function updated(user $user): void
    {
        //
    }

    /**
     * Handle the user "deleted" event.
     */
    public function deleted(user $user): void
    {
        //
    }

    /**
     * Handle the user "restored" event.
     */
    public function restored(user $user): void
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     */
    public function forceDeleted(user $user): void
    {
        //
    }
}
