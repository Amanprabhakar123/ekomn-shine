<?php

namespace App\Notifications;

use App\Models\ReturnOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReturnDeclinedApporvedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

     protected $details;
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
        $name =  $this->details['name'];
        $return_number = $this->details['return_number'];
        $status = $this->details['status'];
        if($status == ReturnOrder::STATUS_APPROVED){

        return (new MailMessage)
            ->subject('eKomn – Return '.$return_number.' is approved.')
            ->view('email.returnApproved', compact('name', 'return_number'));
        }else if($status == ReturnOrder::STATUS_REJECTED){
            return (new MailMessage)
            ->subject('eKomn – Return '.$return_number.' is decline.')
            ->view('email.returnDeclined', compact('name', 'return_number'));
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
