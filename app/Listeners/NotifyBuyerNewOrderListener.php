<?php

namespace App\Listeners;

use App\Events\NewOrderCreatedEvent;
use App\Notifications\NewOrderBuyerNotification;
use Illuminate\Support\Facades\Notification;

class NotifyBuyerNewOrderListener
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
    public function handle(NewOrderCreatedEvent $event): void
    {
        $order = $event->order;
        $user = $event->user;
        // Send the notification

        Notification::send($user, new NewOrderBuyerNotification($order, $user));
    }
}
