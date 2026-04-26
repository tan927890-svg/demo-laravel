<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        return redirect()->route('services.booking');
    }

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

        Contact::create([
            'name'    => $validated['name'],
            'email'   => $validated['email'] ?? null,
            'phone'   => $validated['phone'],
            'subject' => $validated['subject'] ?? $validated['car_interest'] ?? null,
            'message' => $validated['message'],
            'is_read' => false,
        ]);

        return redirect()->back()->with('success', 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi trong vòng 2 giờ làm việc.');
    }
}