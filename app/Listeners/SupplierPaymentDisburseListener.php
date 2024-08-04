<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\SupplierPaymentDisburseEvent;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SupplierPaymentDisburseNotification;

class SupplierPaymentDisburseListener implements ShouldQueue
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
    public function handle(SupplierPaymentDisburseEvent $event): void
    {
        $user = $event->supplier;
        $details = $event->details;

        Notification::send($user, new SupplierPaymentDisburseNotification($details));
    }
}
