<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ReturnDeclinedApporvedNotification;

class ReturnDeclinedApprovedListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $user = $event->buyer;
        $details = $event->details;
        $link = User::unsubscribeTokens($user);
        $details['link'] = $link;
        Notification::send($user, new ReturnDeclinedApporvedNotification($details));
    }
}
