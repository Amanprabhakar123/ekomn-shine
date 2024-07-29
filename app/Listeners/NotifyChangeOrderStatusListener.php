<?php

namespace App\Listeners;

use App\Events\OrderStatusChangedEvent;
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
    public function handle(OrderStatusChangedEvent $event): void
    {
        $user = $event->buyer;
        $details = $event->details;
        // Send the notification

        Notification::send($user, new ChangeOrderStatusNotification($details));
    }
}
