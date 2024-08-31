<?php

namespace App\Listeners;

use App\Events\ReturnRaised;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendReturnRaisedNotification
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
    public function handle(ReturnRaised $event): void
    {
        //
    }
}
