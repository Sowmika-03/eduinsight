<?php

namespace App\Mail;

use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class DebugStudentNotification extends Mailable
{
    public $subjectLine;
    public $notificationMessage;
    public $studentName;

    public function __construct($subject, $message, Student $student)
    {
        $this->subjectLine = $subject;
        $this->notificationMessage = $message;
        $this->studentName = $student->user->name;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subjectLine,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.debug-student',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
