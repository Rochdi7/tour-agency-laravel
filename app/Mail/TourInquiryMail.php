<?php

namespace App\Mail;

use App\Models\Tour; // Import Tour model
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class TourInquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    // Make properties public to be available in the view
    public array $formData;
    public Tour $tour; // Store the tour object

    /**
     * Create a new message instance.
     * @param array $formData The validated form data
     * @param Tour $tour The tour being inquired about
     */
    public function __construct(array $formData, Tour $tour)
    {
        $this->formData = $formData;
        $this->tour = $tour;
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
            // Specific subject line including the tour title
            subject: 'Tour Inquiry: ' . $this->tour->title . ' (from ' . ($senderName ?: $senderEmail) . ')',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            // Point to the new markdown view we created
            markdown: 'emails.tours.inquiry',
            // No 'with' needed as public properties are passed automatically
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
                    ->subject('Tour Inquiry: ' . $this->tour->title . ' (from ' . $senderName . ')')
                    ->markdown('emails.tours.inquiry')
                    ->with([
                        'formData' => $this->formData,
                        'tour' => $this->tour
                    ]);
    }
}