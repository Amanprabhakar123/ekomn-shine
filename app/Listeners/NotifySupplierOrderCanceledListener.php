<?php

namespace App\Listeners;

use App\Events\OrderCanceledEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CancelOrderSupplierNotification;

class NotifySupplierOrderCanceledListener implements ShouldQueue
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
    public function handle(OrderCanceledEvent $event): void
    {
        $user = $event->supplier;
        $details = $event->details;
        // Send the notification

        Notification::send($user, new CancelOrderSupplierNotification($details));

    }
}
