<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewOrderBuyerNotification;

class NotifyBuyerOrderCanceledListener implements ShouldQueue
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
