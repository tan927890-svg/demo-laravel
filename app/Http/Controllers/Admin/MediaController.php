<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    /**
     * Upload ảnh từ TinyMCE editor
     * POST /admin/media/upload
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:5120', // max 5MB
        ]);

        $file = $request->file('file');

        // Tên file: timestamp + random + extension
        $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();

        // Lưu vào public/images/news/
        $destination = public_path('images/news');
        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        $file->move($destination, $filename);

        $url = asset('images/news/' . $filename);

        // TinyMCE yêu cầu trả về { location: "url" }
        return response()->json([
            'location' => $url,
            'url'      => $url,
        ]);
    }

    /**
     * Lấy danh sách ảnh trong public/images
     * GET /admin/media/images
     */
   public function images()
{
    $files = [];

    $dir = public_path('images');
    if (\Illuminate\Support\Facades\File::isDirectory($dir)) {
        foreach (\Illuminate\Support\Facades\File::allFiles($dir) as $file) {
            if (in_array(strtolower($file->getExtension()), ['jpg','jpeg','png','gif','webp','avif'])) {
                $relativePath = 'images/' . str_replace('\\', '/', $file->getRelativePathname());
                $files[] = asset($relativePath);
            }
        }
    }

    return response()->json($files);
}
}
