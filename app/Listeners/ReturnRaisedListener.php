<?php

namespace App\Listeners;

use App\Events\ReturnRaisedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ReturnRaisedNotification;

class ReturnRaisedListener implements ShouldQueue
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
    public function handle(ReturnRaisedEvent $event): void
    {
        $user = $event->supplier;
        $details = $event->details;

        Notification::send($user, new ReturnRaisedNotification($details));
    }
}
