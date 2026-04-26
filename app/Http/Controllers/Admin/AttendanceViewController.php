<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use App\Exports\AttendanceExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceViewController extends Controller
{
    // Danh sách chấm công hôm nay của tất cả nhân viên
    public function index()
    {
        $user  = Auth::user();
        $today = now()->toDateString();

        $users = User::when($user->isManager(), fn($q) => $q->where('role', 'staff'))
            ->when($user->isAdmin(), fn($q) => $q->whereIn('role', ['staff', 'manager']))
            ->where('id', '!=', $user->id)
            ->get();

        $todayRecords = Attendance::where('work_date', $today)
            ->whereIn('user_id', $users->pluck('id'))
            ->get()
            ->keyBy('user_id');

        return view('admin.attendance.index', compact('users', 'todayRecords', 'today'));
    }

    // Xem lịch sử chấm công của 1 nhân viên
    public function show(User $user)
    {
        $auth = Auth::user();

        if ($auth->isManager() && $user->role !== 'staff') {
            abort(403);
        }

        $history = Attendance::where('user_id', $user->id)
            ->orderByDesc('work_date')
            ->paginate(30);

        return view('admin.attendance.show', compact('user', 'history'));
    }

    // Export tất cả nhân viên (trang index)
    public function export(Request $request)
    {
        $month    = $request->get('month'); // VD: 2026-04
        $filename = 'cham-cong-' . ($month ?? now()->format('Y-m')) . '.xlsx';

        return Excel::download(new AttendanceExport(null, $month), $filename);
    }

    // Export riêng 1 nhân viên (trang show)
    public function exportUser(User $user, Request $request)
    {
        $auth = Auth::user();

        if ($auth->isManager() && $user->role !== 'staff') {
            abort(403);
        }

        $month    = $request->get('month');
        $filename = 'cham-cong-' . \Str::slug($user->name) . '-' . ($month ?? now()->format('Y-m')) . '.xlsx';

        return Excel::download(new AttendanceExport($user->id, $month), $filename);
    }
}