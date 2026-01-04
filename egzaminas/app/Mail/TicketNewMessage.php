<?php

namespace App\Mail;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketNewMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $messageContent;

    public function __construct(Ticket $ticket, $messageContent)
    {
        $this->ticket = $ticket;
        $this->messageContent = $messageContent;
    }

    public function build()
    {
        return $this->subject('New Message on Your Ticket')
                    ->html("
                        <p>Hello {$this->ticket->user->name},</p>
                        <p>A new message has been added to your ticket <strong>'{$this->ticket->title}'</strong>:</p>
                        <blockquote>{$this->messageContent}</blockquote>
                        <p>Status: {$this->ticket->status}</p>
                        <p>View your ticket in your dashboard to reply or check updates.</p>
                    ");
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ticket New Message',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
        );
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
