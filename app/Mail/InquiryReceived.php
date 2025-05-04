<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address; // Use this for sender

class InquiryReceived extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The inquiry data.
     *
     * @var array
     */
    public array $inquiryData;

    /**
     * The dynamic subject line for the email.
     *
     * @var string
     */
    public string $emailSubject;

    /**
     * Create a new message instance.
     *
     * @param array $inquiryData The validated form data.
     * @param string $emailSubject The subject for the email notification.
     * @return void
     */
    public function __construct(array $inquiryData, string $emailSubject)
    {
        $this->inquiryData = $inquiryData;
        $this->emailSubject = $emailSubject;
    }

    /**
     * Get the message envelope.
     * Sets the Subject and Reply-To headers.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            // Set Reply-To to the user's email for easy response
            replyTo: [
                new Address($this->inquiryData['email'], $this->inquiryData['name'])
            ],
            subject: $this->emailSubject, // Use the dynamic subject
        );
    }

    /**
     * Get the message content definition.
     * Points to the Markdown view.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.inquiries.general', // Path to your Blade view
             with: [ // Pass data explicitly to the view
                'data' => $this->inquiryData,
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
        return []; // No attachments by default
    }
}