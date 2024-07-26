<?php

namespace App\Listeners;

use App\Notifications\NewOrderBuyerNotification;
use Illuminate\Support\Facades\Notification;

class NotifyBuyerOrderCanceledListener
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

        Notification::send($user, new NewOrderBuyerNotification($order, $user));

    }
}
