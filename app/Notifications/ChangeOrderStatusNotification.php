<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ChangeOrderStatusNotification extends Notification
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
        $order_number = $this->details['order_number'];
        $link = $this->details['link'];

        if($this->details['status'] == Order::STATUS_DISPATCHED){ 
            return (new MailMessage)
            ->subject('eKomn – Order '.$order_number.' Dispatched.')
            ->view('email.orderDispatched', compact('name', 'order_number', 'link'));
        }
        elseif($this->details['status'] == Order::STATUS_DELIVERED){ 
            $tracking_number = $this->details['tracking_number'];
            $courier_name = $this->details['courier_name'];
            return (new MailMessage)
            ->subject('eKomn – Order '.$order_number.' Delivered.')
            ->view('email.orderDelivered', compact('name', 'order_number', 'courier_name', 'tracking_number', 'link'));
        }
        elseif($this->details['status'] == Order::STATUS_RETURN_FILLED){ 
            return (new MailMessage)
            ->subject('eKomn – Order '.$order_number.' Cancelled.')
            ->view('email.orderReturn.blade', compact('name', 'order_number', 'link'));
        }
        
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
