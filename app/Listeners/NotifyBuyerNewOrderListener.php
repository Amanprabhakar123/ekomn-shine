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
        $buyer = $event->buyer;
        $details = $event->details;
        Notification::send($buyer, new NewOrderBuyerNotification($details));
    }
}
