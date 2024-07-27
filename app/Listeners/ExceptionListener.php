<?php

namespace App\Listeners;

use App\Notifications\ExceptionNotification;
use Illuminate\Support\Facades\Notification;

class ExceptionListener
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
        // Extract the message, line number, and file path from the $event object
        $message = $event->message; // Get the message from $event
        $line = $event->line; // Get the line number from $event
        $file = $event->file;        //  file path from $event
        $mailIdFromConfig = config('MAIL_IDs'); // Get the email ID from the configuration file

        // Send the notification to $user using ExceptionNotification
        Notification::send($mailIdFromConfig, new ExceptionNotification($message, $line, $file));

    }
}
