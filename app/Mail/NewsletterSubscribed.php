<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterSubscribed extends Mailable
{
    use Queueable, SerializesModels;

    public string $email;
    public bool   $isAdmin;

    public function __construct(string $email, bool $isAdmin = false)
    {
        $this->email   = $email;
        $this->isAdmin = $isAdmin;
    }

    public function build(): self
    {
        if ($this->isAdmin) {
            return $this->subject('📬 Đăng ký newsletter mới: ' . $this->email)
                        ->view('emails.newsletter-admin');
        }

        return $this->subject('✅ AUTO X – Đăng ký nhận tin thành công')
                    ->view('emails.newsletter-user');
    }
}
