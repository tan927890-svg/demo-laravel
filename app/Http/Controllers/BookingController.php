<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function create()
    {
        return view('dat-lich-dich-vu');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ho_ten'     => 'required|string|max:100',
            'dien_thoai' => 'required|string|max:20',
            'email'      => 'required|email|max:100',
            'ngay'       => 'required|date|after:today',
        ]);

        $data = array_merge($validated, $request->only([
            'chu_de', 'hang_xe', 'mau_xe', 'bien_so',
            'so_km', 'gio', 'ghi_chu', 'dich_vu'
        ]));

        $ref = 'AX-' . date('Y') . '-' . rand(1000, 9999);
        $data['ref'] = $ref;

        // Lưu vào bảng contacts
        $dichVu = $request->dich_vu ?? 'Đặt lịch dịch vụ';
        Contact::create([
            'name'         => $request->ho_ten,
            'phone'        => $request->dien_thoai,
            'email'        => $request->email,
            'subject'      => 'Đặt lịch: ' . $dichVu . ' — ' . $ref,
            'car_interest' => $request->hang_xe,
            'message'      => implode("\n", array_filter([
                'Dịch vụ: ' . $dichVu,
                'Ngày: ' . $request->ngay . ' ' . $request->gio,
                'Xe: ' . $request->hang_xe . ' ' . $request->mau_xe,
                'Biển số: ' . $request->bien_so,
                'Số km: ' . $request->so_km,
                'Ghi chú: ' . $request->ghi_chu,
                'Mã đặt lịch: ' . $ref,
            ])),
            'is_read'      => false,
        ]);

        try {
            Mail::send('emails.booking', $data, function ($m) use ($data) {
                $m->to(env('MAIL_GARAGE_EMAIL', env('MAIL_FROM_ADDRESS')))
                  ->subject('🔧 Đặt lịch mới: ' . $data['ho_ten'] . ' — ' . $data['ref']);
            });

            Mail::send('emails.booking_confirm', $data, function ($m) use ($data) {
                $m->to($data['email'])
                  ->subject('✅ Xác nhận đặt lịch - AUTO X (' . $data['ref'] . ')');
            });
        } catch (\Exception $e) {
            Log::error('Booking mail error: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'ref'     => $ref,
        ]);
    }
}