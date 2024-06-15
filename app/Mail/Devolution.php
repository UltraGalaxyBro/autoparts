<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Devolution extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public readonly array $data)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('lojavirtual@exemplo.com.br', 'CO2 Peças | E-commerce'),
            subject: 'Solicitação de devolução',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            html: 'mails.devolution',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $data = $this->data['attachments'];
        $attachments = [];

        if (!empty($data)) {
            foreach ($data as $attachment) {
                array_push($attachments,  Attachment::fromPath($attachment->getPathName())
                    ->as($attachment->getClientOriginalName())
                    ->withMime($attachment->getMimeType()));
            }
        }

        // PASSANDO OS ANEXOS, SE HOUVER
        return $attachments;
    }
}
