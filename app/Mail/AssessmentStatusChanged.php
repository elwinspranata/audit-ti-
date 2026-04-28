<?php

namespace App\Mail;

use App\Models\Assessment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AssessmentStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public Assessment $assessment;
    public string $previousStatus;

    /**
     * Create a new message instance.
     */
    public function __construct(Assessment $assessment, string $previousStatus)
    {
        $this->assessment = $assessment;
        $this->previousStatus = $previousStatus;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $statusText = match($this->assessment->status) {
            Assessment::STATUS_APPROVED => 'Disetujui',
            Assessment::STATUS_REJECTED => 'Ditolak',
            Assessment::STATUS_VERIFIED => 'Terverifikasi',
            default => 'Diperbarui',
        };

        return new Envelope(
            subject: "Assessment Anda {$statusText}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.assessment-status-changed',
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
