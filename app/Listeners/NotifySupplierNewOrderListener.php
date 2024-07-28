<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewOrderBuyerNotification;

class NotifySupplierNewOrderListener implements ShouldQueue
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

        Notification::send($user, new NewOrderBuyerNotification($order, $user));

    }
}
