<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ChangeOrderStatusNotification;

class NotifyChangeOrderStatusListener implements ShouldQueue
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
        $user = $event->user;
        $order = $event->order;
        // Send the notification

        Notification::send($user, new ChangeOrderStatusNotification($order, $user));
    }
}
