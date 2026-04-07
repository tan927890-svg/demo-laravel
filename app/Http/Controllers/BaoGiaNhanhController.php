<?php

namespace App\Http\Controllers;

use App\Models\BaoGiaNhanh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class BaoGiaNhanhController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'ten'           => 'required|string|max:100',
            'so_dien_thoai' => 'required|string|max:20',
            'dong_xe'       => 'nullable|string|max:100',
        ]);

        $data = BaoGiaNhanh::create($request->only(['ten', 'so_dien_thoai', 'dong_xe']));

        try {
            Mail::send([], [], function ($message) use ($data) {
                $message->to('tan927890@gmail.com')
                        ->subject('Có khách hàng mới đăng ký báo giá!')
                        ->html("
                            <h2 style='color:#1a7a3c;'>Khách hàng mới đăng ký báo giá</h2>
                            <table style='border-collapse:collapse;width:100%;'>
                                <tr>
                                    <td style='padding:8px;border:1px solid #ddd;'><strong>Tên</strong></td>
                                    <td style='padding:8px;border:1px solid #ddd;'>{$data->ten}</td>
                                </tr>
                                <tr>
                                    <td style='padding:8px;border:1px solid #ddd;'><strong>Số điện thoại</strong></td>
                                    <td style='padding:8px;border:1px solid #ddd;'>{$data->so_dien_thoai}</td>
                                </tr>
                                <tr>
                                    <td style='padding:8px;border:1px solid #ddd;'><strong>Dòng xe quan tâm</strong></td>
                                    <td style='padding:8px;border:1px solid #ddd;'>{$data->dong_xe}</td>
                                </tr>
                                <tr>
                                    <td style='padding:8px;border:1px solid #ddd;'><strong>Thời gian</strong></td>
                                    <td style='padding:8px;border:1px solid #ddd;'>{$data->created_at}</td>
                                </tr>
                            </table>
                            <p style='color:#999;margin-top:16px;'>Vui lòng liên hệ khách hàng sớm nhất có thể!</p>
                        ");
            });
        } catch (\Exception $e) {
            Log::error('Gửi mail báo giá thất bại: ' . $e->getMessage());
        }

        return response()->json(['success' => true]);
    }
}