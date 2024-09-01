<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewOrderBuyerNotification;
use App\Notifications\NewOrderSupplierNotification;

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
        $link = User::unsubscribeTokens($supplier);
        $details['link'] = $link;
        Notification::send($supplier, new NewOrderSupplierNotification($details));

    }
}
