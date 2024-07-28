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
        $buyer = $event->buyer;
        $details = $event->details;
        Notification::send($buyer, new NewOrderBuyerNotification($details));
    }
}
