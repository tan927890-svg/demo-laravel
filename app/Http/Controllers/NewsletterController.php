<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewsletterSubscribed;
use App\Models\Newsletter; // ← thêm

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $email = $request->input('email');

        // Lưu vào DB — updateOrCreate để tránh trùng email
        Newsletter::updateOrCreate(
            ['email' => $email],
            ['status' => 'active']
        );

        // Gửi mail xác nhận cho người dùng
        Mail::to($email)->send(new NewsletterSubscribed($email));

        // Gửi thông báo cho admin
        Mail::to(config('mail.admin_email', 'admin@autox.vn'))
            ->send(new NewsletterSubscribed($email, true));

        return response()->json([
            'success' => true,
            'message' => 'Đăng ký thành công!',
        ]);
    }
}