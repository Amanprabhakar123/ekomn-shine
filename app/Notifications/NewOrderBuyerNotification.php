<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderBuyerNotification extends Notification
{
    use Queueable;

    protected $details;

    /**
     * Create a new notification instance.
     */
    public function __construct($details)
    {
        $this->details = $details;
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

        $name = $notifiable->companyDetails->first_name . ' ' . $notifiable->companyDetails->last_name;
        $order_number = $this->details['order_id'];

        return (new MailMessage)
            ->subject('eKomn – New Order '.$order_number.' is created.')
            ->view('email.orderCancellation', compact('name', 'order_number'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            // Add your custom data here if needed
        ];
    }
}
