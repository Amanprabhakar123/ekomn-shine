<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderSupplierNotification extends Notification
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
        $order_type = $this->details['order_type'];
        $link = $this->details['link'];

        return (new MailMessage)
            ->subject('eKomn – New '.$order_type.' Order Received. Process Today!!')
            ->view('email.newOrderSupplierCreate', compact('name', 'order_type', 'link'));
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
