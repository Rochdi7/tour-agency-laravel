<?php

namespace App\Mail;

use App\Models\Activity; // Import Activity model
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class ActivityInquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $formData;
    public Activity $activity; // Store the activity object

    /**
     * Create a new message instance.
     * @param array $formData The validated form data
     * @param Activity $activity The activity being inquired about
     */
    public function __construct(array $formData, Activity $activity)
    {
        $this->formData = $formData;
        $this->activity = $activity;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $senderName = $this->formData['name'] ?? null;
        $senderEmail = $this->formData['email'];

        return new Envelope(
            replyTo: [
                new Address($senderEmail, $senderName)
            ],
            subject: 'Activity Inquiry: ' . $this->activity->title . ' (from ' . ($senderName ?: $senderEmail) . ')',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.activities.inquiry', // New markdown view
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
    public function build()
    {
        $senderName = $this->formData['name'] ?? 'Visitor';
        $senderEmail = $this->formData['email'] ?? 'noreply@example.com';

        return $this->from($senderEmail, $senderName)
                    ->replyTo($senderEmail, $senderName)
                    ->subject('Activity Inquiry: ' . $this->activity->title . ' (from ' . $senderName . ')')
                    ->markdown('emails.activities.inquiry')
                    ->with([
                        'formData' => $this->formData,
                        'activity' => $this->activity
                    ]);
    }
}