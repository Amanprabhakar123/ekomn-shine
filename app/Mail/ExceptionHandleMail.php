<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ExceptionHandleMail extends Mailable
{
    use Queueable, SerializesModels;

    public $text;

    public $file;

    public $line;

    public function __construct($message, $line, $file)
    {
        $this->text = (string) $message;
        $this->line = (string) $line;
        $this->file = (string) $file;
    }

    public function build()
    {
        return $this->view('email.exception')->subject('Exception Notification')
            ->with([
                'text' => $this->text,
                'line' => $this->line,
                'file' => $this->file,
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
        return new Content(view: 'email.exception');
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
