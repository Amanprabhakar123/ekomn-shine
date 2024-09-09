<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    
    protected $user;
    /**
     * Create a new message instance.
     */
    public function __construct( $user)
    {
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to '.env('APP_NAME'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $link = User::unsubscribeTokens($this->user);
        $content = new Content(view: 'email.welcome');
        $role = $this->user->hasRole(User::ROLE_SUPPLIER) ? User::ROLE_SUPPLIER : User::ROLE_BUYER;
        $content->with(['role' => $role, 'user' => $this->user, 'link' => $link]);


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
