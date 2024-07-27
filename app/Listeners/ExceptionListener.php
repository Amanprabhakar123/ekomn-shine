<?php

namespace App\Listeners;

use App\Mail\ExceptionHandleMail;
use App\Notifications\ExceptionNotification;
use Illuminate\Support\Facades\Mail;
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
        $message = $event->message;
        $line = $event->line;
        $file = $event->file;

        // Get the email IDs from the configuration file
        $mailIDs = config('mail.MAIL_IDs');

        // Convert the comma-separated string into an array
        $mailIDsArray = explode(',', $mailIDs);

        // Send notification to the email IDs using ExceptionNotification
        Mail::to($mailIDsArray)->send(new ExceptionHandleMail($message, $line, $file));
    }
}
