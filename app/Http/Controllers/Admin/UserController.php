<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\UserLog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())
            ->when(Auth::user()->isManager(), fn($q) =>
                $q->where('role', 'staff'))
            ->with('logs')
            ->latest()
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users|alpha_dash',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'role'     => 'required|in:admin,manager,staff',
        ], [
            'username.required'   => 'Tên đăng nhập là bắt buộc.',
            'username.unique'     => 'Tên đăng nhập đã tồn tại.',
            'username.alpha_dash' => 'Tên đăng nhập chỉ được chứa chữ cái, số, _ và -.',
        ]);

        if (Auth::user()->isManager() && $request->role !== 'staff') {
            abort(403, 'Manager chỉ được tạo tài khoản nhân viên.');
        }

        User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('admin.users.index')
                         ->with('success', 'Tạo tài khoản thành công!');
    }

    public function show(User $user)
    {
        if (Auth::user()->isManager() && $user->role !== 'staff') {
            abort(403);
        }

        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        if (Auth::user()->isManager() && $user->role !== 'staff') {
            abort(403);
        }

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (Auth::user()->isManager() && $user->role !== 'staff') {
            abort(403);
        }

        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:50|alpha_dash|unique:users,username,' . $user->id,
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'role'     => 'required|in:admin,manager,staff',
            'status'   => 'nullable|in:active,blocked',
        ], [
            'username.required'   => 'Tên đăng nhập là bắt buộc.',
            'username.unique'     => 'Tên đăng nhập đã tồn tại.',
            'username.alpha_dash' => 'Tên đăng nhập chỉ được chứa chữ cái, số, _ và -.',
        ]);

        if (Auth::user()->isManager() && $request->role !== 'staff') {
            abort(403, 'Manager chỉ được gán role nhân viên.');
        }

        $labels = [
            'name'     => 'Tên',
            'username' => 'Tên đăng nhập',
            'email'    => 'Email',
            'role'     => 'Vai trò',
            'status'   => 'Trạng thái',
        ];
        $changes = [];

        foreach (['name', 'username', 'email', 'role', 'status'] as $field) {
            $newVal = $request->$field;
            if ($newVal !== null && (string) $user->$field !== (string) $newVal) {
                $changes[] = [
                    'field' => $labels[$field],
                    'old'   => $user->$field,
                    'new'   => $newVal,
                ];
            }
        }

        DB::table('users')->where('id', $user->id)->update([
            'name'       => $request->name,
            'username'   => $request->username,
            'email'      => $request->email,
            'role'       => $request->role,
            'status'     => $request->status ?? $user->status,
            'updated_at' => now(),
        ]);

        if (!empty($changes)) {
            UserLog::create([
                'user_id'   => $user->id,
                'causer_id' => Auth::id(),
                'action'    => 'updated',
                'changes'   => json_encode($changes), // ← đã sửa
            ]);
        }

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:6']);

            DB::table('users')->where('id', $user->id)->update([
                'password'          => Hash::make($request->password),
                'remember_token'    => Str::random(60),
                'password_reset_at' => now(),
                'updated_at'        => now(),
            ]);

            DB::table('sessions')->where('user_id', $user->id)->delete();

            UserLog::create([
                'user_id'   => $user->id,
                'causer_id' => Auth::id(),
                'action'    => 'password_reset_by_admin',
                'changes'   => null,
            ]);
        }

        return redirect()->route('admin.users.index')
                         ->with('success', 'Cập nhật tài khoản thành công!');
    }

    public function destroy(User $user)
    {
        if (Auth::user()->isManager() && $user->role !== 'staff') {
            abort(403, 'Manager chỉ được xóa tài khoản nhân viên.');
        }

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Không thể xóa tài khoản của chính mình.');
        }

        $user->delete();

        return back()->with('success', 'Đã xóa tài khoản.');
    }

    public function resetPassword(User $user)
    {
        $newPassword = Str::random(10);

        $user->update([
            'password' => Hash::make($newPassword),
        ]);

        \Illuminate\Support\Facades\Mail::to($user->email)->send(
            new \App\Mail\OtpMail($newPassword)
        );

        return response()->json(['message' => 'Đã gửi mật khẩu mới về email nhân viên.']);
    }
}