<?php

namespace App\Listeners;

use App\Events\NewOrderCreatedEvent;
use App\Mail\OrderCreatedMail;
use Illuminate\Support\Facades\Mail;

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
        $order = $event->order;
        $user = $event->user;
        // Send the email
        Mail::to('khanzub016@gmail.com')->send(new OrderCreatedMail($order, $user));
    }
}
