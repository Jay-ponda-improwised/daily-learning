<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;

class SMTPTesting extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(){}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'S M T P Testing',
            from: new Address('jay.ponda@improwised.com', 'Jay Ponda'),
            tags: ['testing'],
            metadata: ['type' => 'email'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail_demo',
            with: [
                'name' => 'Jay Ponda',
                'title' => 'SMTP Testing',
                'content' => 'This is a test message',
                'columns' => ['id', 'name', 'email'],
                'url' => "http://172.31.0.4:8425",
                'entries' => [
                    [
                        'id' => 1,
                        'name' => 'John Doe',
                        'email' => '0oFkE@example.com',
                    ],
                    [
                        'id' => 2,
                        'name' => 'Jane Doe',
                        'email' => 'ZzL5I@example.com',
                    ]
                ]
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromPath(public_path('images/bg.jpg'))
                ->as('test-image.jpg')
                ->withMime('image/jpg')
        ];
    }
}
