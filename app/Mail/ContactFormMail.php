<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $formData;

    /**
     * Create a new message instance.
     * @param array $formData The validated data
     */
    public function __construct(array $formData)
    {
        $this->formData = $formData;
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $senderName = $this->formData['name'] ?? null;
        $senderEmail = $this->formData['email']; // Assumes validation passed

        return new Envelope(
            replyTo: [
                new Address($senderEmail, $senderName)
            ],
            subject: 'Morocco Quest Contact Form Submission - ' . ($senderName ?: $senderEmail),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.contact.form', // Path: resources/views/emails/contact/form.blade.php
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
            ->subject('Morocco Quest Contact Form Submission - ' . $senderName)
            ->markdown('emails.contact.form')
            ->with([
                'formData' => $this->formData,
            ]);
    }
}