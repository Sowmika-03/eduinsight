<?php

namespace App\Mail;

use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ParentNotification extends Mailable
{

    public $emailSubject;
    public $emailMessage;
    public $parentName;
    public $studentName;

    /**
     * Create a new message instance.
     */
    public function __construct($subject, $message, Student $student)
    {
        $this->emailSubject = $subject;
        $this->emailMessage = $message;
        $this->parentName = $student->parent?->name ?? 'Parent/Guardian';
        $this->studentName = $student->user->name ?? 'Student';
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->emailSubject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.parent-notification',
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
