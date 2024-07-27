<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExceptionNotification extends Notification
{
    use Queueable;

    protected $message;

    protected $file;

    protected $line;

    /**
     * Create a new notification instance.
     */
    public function __construct($message, $line, $file)
    {
        $this->message = $message;
        $this->line = $line;
        $this->file = $file;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Exception Notification')
            ->line('An exception has occurred.')
            ->line('Message: '.$this->message)
            ->line('File: '.$this->file)
            ->line('Line: '.$this->line);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
