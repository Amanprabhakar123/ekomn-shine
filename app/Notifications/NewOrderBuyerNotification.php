<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderBuyerNotification extends Notification
{
    use Queueable;

    protected $order;

    protected $email;

    /**
     * Create a new notification instance.
     */
    public function __construct($order, $email)
    {
        $this->order = $order;
        $this->email = $email;
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
            ->subject('New Order Notification')
            ->line('The introduction to the notification.')
            ->action('View Order', url('my-orders'))
            ->line('Thank you for using our application!');
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

    /**
     * Override the routeNotificationForMail method to dynamically set the recipient email.
     *
     * @return string
     */
    public function routeNotificationForMail($notifiable)
    {
        return $this->email;
    }
}
