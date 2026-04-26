<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PickupDeliveryRequest extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[AUTO X] Yêu cầu ' . $this->data['loai_dich_vu'] . ' — ' . $this->data['ho_ten'],
        );
    }

    public function content(): Content
    {
       return new Content(
    view: 'emails.pickup-delivery-email',
);
    }
}
