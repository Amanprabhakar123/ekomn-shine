<?php

namespace App\Listeners;

use App\Notifications\ExceptionNotification;
use Illuminate\Support\Facades\Notification;

class ExceptionListener
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
        $order = $event->order;
        $user = $event->user;
        // Send the notification

        Notification::send($user, new ExceptionNotification($order, $user));

    }
}
