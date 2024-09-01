<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SupplierPaymentDisburseNotification extends Notification
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
        $order_number = $this->details['order_id'];
        $link = $this->details['link'];

        return (new MailMessage)
            ->subject('eKomn – Order '.$order_number.' Payment Received.')
            ->view('email.supplierPaymentDisbursment', compact('name', 'order_type', 'order_number', 'link'));
                    
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
