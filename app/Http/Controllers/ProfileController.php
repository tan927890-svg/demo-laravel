<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        return view('admin.profile.edit', ['user' => auth()->user()]);
    }

    /**
     * Cập nhật thông tin cá nhân + avatar
     * Avatar lưu vào: public/images/avatars/
     * Hiển thị qua: /images/avatars/filename.jpg
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'avatar'   => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->only('name', 'username', 'email');

        // Xử lý upload avatar
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            // Xóa avatar cũ nếu có
            if ($user->avatar) {
                $oldPath = public_path('images/' . $user->avatar);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $file      = $request->file('avatar');
            $filename  = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            $destDir   = public_path('images/avatars');

            // Tạo thư mục nếu chưa có
            if (!is_dir($destDir)) {
                mkdir($destDir, 0755, true);
            }

            $file->move($destDir, $filename);

            // Lưu path tương đối vào DB: "avatars/filename.jpg"
            $data['avatar'] = 'avatars/' . $filename;
        }

        $user->update($data);

        return redirect()->route('admin.profile')
            ->with('success', 'Cập nhật thông tin thành công!')
            ->with('tab', 'info');
    }

    /**
     * Đổi mật khẩu
     */
    public function password(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => 'required',
            'password'         => ['required', 'confirmed', Password::min(6)],
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()
                ->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.'])
                ->with('tab', 'password');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.profile')
            ->with('success', 'Đổi mật khẩu thành công!')
            ->with('tab', 'password');
    }
}