<?php

namespace App\Mail;

use App\Models\Deposit;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DepositConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Deposit $deposit) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[AUTO X] Xác nhận đặt cọc – ' . $this->deposit->car->name
                     . ' · Mã GD: ' . $this->deposit->transaction_code,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.deposit-confirmation',
        );
    }
}
