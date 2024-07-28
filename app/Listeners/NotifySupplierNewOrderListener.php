<?php

namespace App\Listeners;

use App\Notifications\NewOrderSupplierNotification;
use Illuminate\Support\Facades\Notification;

class NotifySupplierNewOrderListener
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
