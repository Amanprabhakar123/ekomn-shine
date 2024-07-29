<?php

namespace App\Listeners;

use App\Events\OrderCanceledEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CancelOrderBuyerNotification;

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
    public function handle(OrderCanceledEvent $event): void
    {
        $user = $event->buyer;
        $details = $event->details;
        Notification::send($user, new CancelOrderBuyerNotification($details));

    }
}
