<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login'    => ['required', 'string'],
            'password' => ['required'],
        ]);

        $loginValue = trim($request->input('login'));

        $field = filter_var($loginValue, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $field     => $loginValue,
            'password' => $request->password,
        ];

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'login' => 'Tên đăng nhập hoặc mật khẩu không đúng.',
            ])->onlyInput('login');
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->role === 'staff') {
            $today = now()->toDateString();
            $checkedIn = \App\Models\Attendance::where('user_id', $user->id)
                ->where('work_date', $today)
                ->whereNotNull('check_in_at')
                ->exists();

            return $checkedIn
                ? redirect()->intended(route('admin.staff.attendance'))
                : redirect()->intended(route('admin.dashboard'));
        }

        return match ($user->role) {
            'admin', 'manager' => redirect()->intended(route('admin.dashboard')),
            default            => redirect()->intended(route('dashboard')),
        };
    }

    public function register(Request $request) {}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    // Đổi private -> public để gọi từ routes/web.php
    public function redirectByRole($user)
    {
        if ($user->role === 'staff') {
            $today = now()->toDateString();
            $checkedIn = \App\Models\Attendance::where('user_id', $user->id)
                ->where('work_date', $today)
                ->whereNotNull('check_in_at')
                ->exists();

            return $checkedIn
                ? redirect()->route('admin.staff.attendance')
                : redirect()->route('admin.dashboard');
        }

        return match ($user->role) {
            'admin', 'manager' => redirect()->route('admin.dashboard'),
            default            => redirect()->route('dashboard'),
        };
    }
}