<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\PickupDeliveryRequest;

class PickupDeliveryController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'loai_dich_vu' => 'required|string',
            'ho_ten'       => 'required|string|max:100',
            'dien_thoai'   => 'required|string|max:20',
            'dia_chi'      => 'required|string|max:255',
            'ngay'         => 'required|date|after:today',
            'khung_gio'    => 'required|string',
            'hang_xe'      => 'nullable|string|max:100',
            'bien_so'      => 'nullable|string|max:20',
            'dich_vu'      => 'required|string',
            'ghi_chu'      => 'nullable|string|max:1000',
        ], [
            'ho_ten.required'     => 'Vui lòng nhập họ và tên.',
            'dien_thoai.required' => 'Vui lòng nhập số điện thoại.',
            'dia_chi.required'    => 'Vui lòng nhập địa chỉ nhận / giao xe.',
            'ngay.required'       => 'Vui lòng chọn ngày.',
            'ngay.after'          => 'Ngày phải từ ngày mai trở đi.',
            'khung_gio.required'  => 'Vui lòng chọn khung giờ.',
            'dich_vu.required'    => 'Vui lòng chọn dịch vụ.',
        ]);

        // Lưu vào bảng contacts
        Contact::create([
            'name'         => $validated['ho_ten'],
            'phone'        => $validated['dien_thoai'],
            'email'        => null,
            'subject'      => $validated['loai_dich_vu'] . ': ' . $validated['dich_vu'],
            'car_interest' => $validated['hang_xe'] ?? null,
            'message'      => implode("\n", array_filter([
                'Loại: ' . $validated['loai_dich_vu'],
                'Dịch vụ: ' . $validated['dich_vu'],
                'Địa chỉ: ' . $validated['dia_chi'],
                'Ngày: ' . $validated['ngay'] . ' ' . $validated['khung_gio'],
                'Xe: ' . ($validated['hang_xe'] ?? '') . ' — Biển số: ' . ($validated['bien_so'] ?? ''),
                'Ghi chú: ' . ($validated['ghi_chu'] ?? ''),
            ])),
            'is_read'      => false,
        ]);

        Mail::to(config('mail.garage_email', 'your@gmail.com'))
            ->send(new PickupDeliveryRequest($validated));

        return back()->with('success', '✓ Yêu cầu đã được gửi! Chúng tôi sẽ gọi xác nhận trong 15 phút.');
    }
}