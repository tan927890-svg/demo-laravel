<?php

namespace App\Http\Controllers;

use App\Mail\MaintenanceReminderMail;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MaintenanceReminderController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'ho_ten'      => 'required|string|max:100',
            'dien_thoai'  => 'required|string|max:20',
            'km_gan_nhat' => 'required|numeric|min:0',
            'hang_xe'     => 'required|string|max:100',
        ], [
            'ho_ten.required'      => 'Vui lòng nhập họ và tên.',
            'dien_thoai.required'  => 'Vui lòng nhập số điện thoại.',
            'km_gan_nhat.required' => 'Vui lòng nhập số km.',
            'km_gan_nhat.numeric'  => 'Số km phải là số.',
            'hang_xe.required'     => 'Vui lòng chọn hãng xe.',
        ]);

        // Lưu vào bảng contacts
        Contact::create([
            'name'         => $validated['ho_ten'],
            'phone'        => $validated['dien_thoai'],
            'email'        => null,
            'subject'      => 'Nhắc bảo dưỡng định kỳ',
            'car_interest' => $validated['hang_xe'],
            'message'      => 'Xe: ' . $validated['hang_xe'] . ' — Số km gần nhất: ' . number_format($validated['km_gan_nhat']) . ' km',
            'is_read'      => false,
        ]);

        Mail::to(config('mail.from.address'))
            ->send(new MaintenanceReminderMail(
                hoTen:       $validated['ho_ten'],
                soDienThoai: $validated['dien_thoai'],
                kmGanNhat:   $validated['km_gan_nhat'],
                hangXe:      $validated['hang_xe'],
            ));

        return response()->json([
            'success' => true,
            'message' => 'Đăng ký thành công! Chúng tôi sẽ nhắc bạn trước hạn bảo dưỡng.',
        ]);
    }
}