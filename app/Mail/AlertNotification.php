<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AlertNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $alertMessage;
    public $recipientName;
    public $alertType;

    /**
     * Create a new message instance.
     */
    public function __construct($alertMessage, $recipientName, $alertType = 'alert')
    {
        $this->alertMessage = $alertMessage;
        $this->recipientName = $recipientName;
        $this->alertType = $alertType;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'EduInsight Alert: ' . ucfirst($this->alertType),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.alert-notification',
            with: [
                'recipientName' => $this->recipientName,
                'alertMessage' => $this->alertMessage,
                'alertType' => $this->alertType,
            ],
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
