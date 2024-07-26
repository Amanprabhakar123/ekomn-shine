<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public $user;

    public function __construct(Order $order, User $user)
    {
        $this->order = $order;
        $this->user = $user;
    }

    public function build()
    {
        return $this->view('email.welcome')->with([
            'name' => $this->order->order_number,
        ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Created Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $content = new Content(view: 'email.welcome');
        $role = $this->user->hasRole(User::ROLE_SUPPLIER) ? User::ROLE_SUPPLIER : User::ROLE_BUYER;
        $content->with(['role' => $role, 'user' => $this->order]);

        return $content;
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
