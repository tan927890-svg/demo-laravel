<?php
// ══════════════════════════════════════════════
// BaoGiaNhanhController.php
// ══════════════════════════════════════════════
namespace App\Http\Controllers;

use App\Mail\BaoGiaMail;
use App\Models\BaoGiaNhanh;
use App\Models\Contact;
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

        $data = BaoGiaNhanh::create(
            $request->only(['ten', 'so_dien_thoai', 'dong_xe'])
        );

        // Lưu vào bảng contacts
        Contact::create([
            'name'         => $request->ten,
            'phone'        => $request->so_dien_thoai,
            'email'        => null,
            'subject'      => 'Báo giá nhanh',
            'car_interest' => $request->dong_xe,
            'message'      => 'Khách yêu cầu báo giá nhanh cho xe: ' . ($request->dong_xe ?? 'Không rõ'),
            'is_read'      => false,
        ]);

        try {
            Mail::to('tan927890@gmail.com')->send(new BaoGiaMail($data));
        } catch (\Exception $e) {
            Log::error('Gửi mail báo giá thất bại: ' . $e->getMessage());
        }

        return response()->json(['success' => true]);
    }
}