<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\BaoGiaNhanh;


class BaoGiaMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public BaoGiaNhanh $data  // truyền thẳng model vào
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🔔 Báo giá mới — ' . $this->data->ten,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.bao-gia',  // trỏ tới blade
        );
    }
    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
