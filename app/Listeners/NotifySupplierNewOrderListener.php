<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\NewOrderSupplierNotification;
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
        $supplier = $event->supplier;
        $details = $event->details;

        Notification::send($supplier, new NewOrderSupplierNotification($details));

    }
}
