<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    /**
     * Helper: query thông báo dành cho một user (thay thế scope forUser)
     * target_role = null / 'all'  → gửi tất cả
     * target_role = 'staff'       → chỉ staff
     * target_role = 'manager'     → chỉ manager
     */
    private function queryForUser($user)
    {
        return Notification::where(function ($q) use ($user) {
            $q->whereNull('target_role')
              ->orWhere('target_role', 'all')
              ->orWhere('target_role', $user->role);
        });
    }

    /**
     * Danh sách thông báo — tất cả role xem được
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin() || $user->role === 'manager') {
            $notifications = Notification::with('creator')
                ->latest()
                ->paginate(20);
        } else {
            $notifications = $this->queryForUser($user)
                ->with('creator')
                ->latest()
                ->paginate(20);
        }

        return view('admin.notifications.index', compact('notifications'));
    }

    /**
     * Form tạo thông báo mới
     */
    public function create()
    {
        return view('admin.notifications.create');
    }

    /**
     * Lưu thông báo mới
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'body'        => 'required|string|max:2000',
            'type'        => 'required|in:info,warning,success,urgent',
            'target_role' => 'nullable|in:all,staff,manager',
        ]);

        Notification::create([
            'created_by'  => Auth::id(),
            'title'       => $request->title,
            'body'        => $request->body,
            'type'        => $request->type,
            'target_role' => $request->target_role ?? null,
        ]);

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Đã gửi thông báo thành công!');
    }

    /**
     * Xóa thông báo (admin only)
     */
    public function destroy(Notification $notification)
    {
        abort_unless(Auth::user()->isAdmin(), 403);
        $notification->delete();

        return back()->with('success', 'Đã xóa thông báo!');
    }

    /**
     * API: lấy thông báo chưa đọc của user hiện tại (dùng cho dropdown)
     */
    public function unread()
    {
        $user  = Auth::user();
        $items = $this->queryForUser($user)
            ->with('creator')
            ->latest()
            ->get()
            ->map(function ($n) use ($user) {
                return [
                    'id'         => $n->id,
                    'title'      => $n->title,
                    'body'       => $n->body,
                    'type'       => $n->type,
                    'icon'       => $n->typeIcon(),
                    'color'      => $n->typeColor(),
                    'is_read'    => $n->isReadBy($user),
                    'creator'    => $n->creator->name ?? '—',
                    'created_at' => $n->created_at->diffForHumans(),
                ];
            });

        $unreadCount = $items->where('is_read', false)->count();

        return response()->json([
            'items'        => $items,
            'unread_count' => $unreadCount,
        ]);
    }

    /**
     * API: lấy thông báo mới nhất sau một ID nhất định (dùng cho polling 30s)
     */
    public function latest(Request $request)
    {
        $user    = Auth::user();
        $afterId = (int) $request->get('after', 0);

        $notif = $this->queryForUser($user)
            ->where('id', '>', $afterId)
            ->latest()
            ->first();

        if (!$notif) {
            return response()->json(null);
        }

        return response()->json([
            'id'   => $notif->id,
            'type' => $notif->type,
        ]);
    }

    /**
     * Đánh dấu đã đọc một thông báo
     */
    public function markRead(Notification $notification)
    {
        $user = Auth::user();

        if (!$notification->isReadBy($user)) {
            $notification->readers()->attach($user->id);
        }

        return response()->json(['ok' => true]);
    }

    /**
     * Đánh dấu đã đọc tất cả
     */
    public function markAllRead()
    {
        $user = Auth::user();

        $ids = $this->queryForUser($user)
            ->pluck('id')
            ->diff($user->readNotifications()->pluck('notification_id'));

        foreach ($ids as $id) {
            DB::table('notification_reads')->insertOrIgnore([
                'notification_id' => $id,
                'user_id'         => $user->id,
                'read_at'         => now(),
            ]);
        }

        return response()->json(['ok' => true]);
    }
}