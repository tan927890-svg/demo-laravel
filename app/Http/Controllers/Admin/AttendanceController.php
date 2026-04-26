<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function checkIn(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        $distance = $this->haversine(
            $request->lat, $request->lng,
            config('app.office.lat'), config('app.office.lng')
        );

        $withinGps = $distance <= config('app.office.radius');

        if (!$withinGps) {
            return response()->json([
                'success'  => false,
                'message'  => "Bạn đang cách văn phòng {$distance}m – cần ở trong vòng " . config('app.office.radius') . "m để chấm công.",
                'distance' => $distance,
            ], 422);
        }

        // Kiểm tra đã check-in hôm nay chưa
        $already = Attendance::where('user_id', auth()->id())
            ->where('type', 'check_in')
            ->whereDate('checked_at', today())
            ->exists();

        if ($already) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn đã check-in hôm nay rồi.',
            ], 422);
        }

        Attendance::create([
            'user_id'    => auth()->id(),
            'type'       => 'check_in',
            'lat'        => $request->lat,
            'lng'        => $request->lng,
            'method'     => 'gps',
            'checked_at' => now(),
        ]);

        return response()->json(['success' => true]);
    }

    private function haversine($lat1, $lng1, $lat2, $lng2): int
    {
        $R  = 6371000;
        $φ1 = deg2rad($lat1); $φ2 = deg2rad($lat2);
        $Δφ = deg2rad($lat2 - $lat1);
        $Δλ = deg2rad($lng2 - $lng1);
        $a  = sin($Δφ/2) ** 2 + cos($φ1) * cos($φ2) * sin($Δλ/2) ** 2;
        return (int) round($R * 2 * atan2(sqrt($a), sqrt(1 - $a)));
    }
}