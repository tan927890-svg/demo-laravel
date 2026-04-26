<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MaintenanceReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $hoTen,
        public string $soDienThoai,
        public string $kmGanNhat,
        public string $hangXe,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🔔 Đăng ký nhắc lịch bảo dưỡng - ' . $this->hoTen,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.maintenance-reminder',
        );
    }
}
