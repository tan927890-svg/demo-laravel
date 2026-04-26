<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Mail\OtpMail;

class ForgotPasswordController extends Controller
{
    public function showForm()
    {
        return view('auth.forgot-password');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
        ], [
            'login.required' => 'Vui lòng nhập tên đăng nhập hoặc email.',
        ]);

        $loginValue = strtolower(trim($request->input('login')));

        // Tìm user theo email hoặc username
        $user = User::where('email', $loginValue)
            ->orWhere('username', $loginValue)
            ->first();

        if (!$user) {
            return back()->withErrors(['login' => 'Tên đăng nhập hoặc email không tồn tại trong hệ thống.']);
        }

        if (!$user->email) {
            return back()->withErrors(['login' => 'Tài khoản này chưa có email để nhận OTP.']);
        }

        session()->forget(['otp_verified', 'otp_email']);

        $otp = rand(100000, 999999);

        DB::table('password_otps')->updateOrInsert(
            ['email' => $user->email],
            [
                'otp'        => bcrypt($otp),
                'ip_address' => $request->ip(),
                'used'       => false,
                'expires_at' => now()->addMinutes(10),
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        Mail::to($user->email)->send(new OtpMail($otp));

        Log::channel('daily')->info('Password reset requested', [
            'email' => $user->email,
            'ip'    => $request->ip(),
            'time'  => now()->toDateTimeString(),
        ]);

        session(['otp_email' => $user->email]);
        return redirect()->route('password.otp');
    }

    public function showOtpForm()
    {
        if (!session('otp_email')) {
            return redirect()->route('password.request');
        }

        session()->forget('otp_verified');

        return view('auth.otp-verify');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);

        $record = DB::table('password_otps')
            ->where('email', session('otp_email'))
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->latest('updated_at')
            ->first();

        if (!$record || !Hash::check($request->otp, $record->otp)) {
            return back()->withErrors(['otp' => 'Mã OTP không đúng hoặc đã hết hạn.']);
        }

        session(['otp_verified' => true]);
        return redirect()->route('password.reset.form');
    }

    public function showNewPasswordForm()
    {
        if (!session('otp_verified')) {
            return redirect()->route('password.request');
        }
        return view('auth.new-password');
    }

    public function resetPassword(Request $request)
    {
        if (!session('otp_verified')) {
            return redirect()->route('password.request');
        }

        $request->validate([
            'password' => 'required|min:8|confirmed',
        ], [
            'password.min'       => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ]);

        $email = strtolower(trim(session('otp_email')));

        DB::table('users')
            ->where('email', $email)
            ->update([
                'password'          => Hash::make($request->password),
                'remember_token'    => Str::random(60),
                'password_reset_at' => now(),
                'updated_at'        => now(),
            ]);

        DB::table('password_otps')
            ->where('email', $email)
            ->update(['used' => true]);

        $user = User::where('email', $email)->first();
        if ($user) {
            UserLog::create([
                'user_id'   => $user->id,
                'causer_id' => null,
                'action'    => 'password_reset_self',
                'changes'   => null,
            ]);
        }

        session()->forget(['otp_email', 'otp_verified']);

        return redirect()->route('login')
            ->with('status', 'Đổi mật khẩu thành công! Vui lòng đăng nhập lại.');
    }
}