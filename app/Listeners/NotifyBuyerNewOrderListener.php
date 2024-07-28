<?php

namespace App\Listeners;

use App\Events\NewOrderCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewOrderBuyerNotification;

class NotifyBuyerNewOrderListener implements ShouldQueue
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
