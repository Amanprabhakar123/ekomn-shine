<?php

namespace App\Listeners;

use App\Notifications\NewOrderSupplierNotification;
use Illuminate\Support\Facades\Notification;

class NotifySupplierOrderCanceledListener
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

        Notification::send($user, new NewOrderSupplierNotification($order, $user));

    }
}
