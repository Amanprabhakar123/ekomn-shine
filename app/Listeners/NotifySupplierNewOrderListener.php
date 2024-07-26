<?php

namespace App\Listeners;

use App\Mail\OrderCreatedMail;
use Illuminate\Support\Facades\Mail;

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
        $order = $event->order;
        $user = $event->user;
        Mail::to('khankhallid425@gmail.com')->send(new OrderCreatedMail($order, $user));

    }
}
