<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\UserRegistered;
use App\Models\AccountBalance;

class CreateAccountBalance implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event)
    {
        // Create a new account balance record for the registered user
        AccountBalance::create([
            'user_id' => $event->user->id,
            'balance' => 0.00, // Or your default initial balance
        ]);
    }
}
