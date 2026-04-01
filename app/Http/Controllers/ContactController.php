<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Hiển thị trang liên hệ
     */
    public function index()
    {
        return view('contact');
    }

    /**
     * Xử lý form liên hệ
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:100',
            'phone'        => 'required|string|max:20',
            'email'        => 'nullable|email|max:100',
            'subject'      => 'nullable|string|max:100',
            'car_interest' => 'nullable|string|max:100',
            'message'      => 'required|string|max:2000',
            'consent'      => 'accepted',
        ], [
            'name.required'    => 'Vui lòng nhập họ và tên.',
            'phone.required'   => 'Vui lòng nhập số điện thoại.',
            'message.required' => 'Vui lòng nhập nội dung tin nhắn.',
            'consent.accepted' => 'Bạn cần đồng ý với chính sách bảo mật.',
        ]);

        // TODO: Gửi email thông báo cho admin
        // Mail::to('support@website.com')->send(new ContactMail($validated));

        return redirect()->route('contact')->with('success', 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi trong vòng 2 giờ làm việc.');
    }
}
