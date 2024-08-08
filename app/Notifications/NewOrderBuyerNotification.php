<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Services\OrderService;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

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
        $order_id = $this->details['id'];

        $service = new OrderService;
        $fileName = $service->orderInvoice($order_id); 
        $originalFullPath = storage_path('app/public/' . $fileName);
        $file = file_get_contents($originalFullPath);

        // attach the file in the email

        $mailMessage = (new MailMessage)
            ->subject('eKomn – New Order '.$order_number.' is created.')
            ->view('email.newOrderBuyerCreate', compact('name', 'order_number'))
            ->attachData($file, $order_number.'.pdf', [
            'mime' => 'application/pdf',
            ]);

        // Delete the file
        unlink($originalFullPath);

        // Delete the directory if it is empty
        $directory = dirname($originalFullPath);
        if (is_dir($directory) && count(scandir($directory)) == 2) {
            rmdir($directory);
        }

        return $mailMessage;
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
