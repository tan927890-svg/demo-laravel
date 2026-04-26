<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::with('category')->latest('published_at')->paginate(20);
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        $categories = NewsCategory::orderBy('name')->get();
        return view('admin.news.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'nullable|string',
            'status'  => 'required|in:published,draft,scheduled',
        ]);

        $data = $request->only([
            'title', 'slug', 'news_category_id', 'excerpt',
            'content', 'status', 'published_at',
        ]);

        $data['slug']    = $this->makeUniqueSlug(!empty($data['slug']) ? $data['slug'] : $data['title']);
        $data['user_id'] = auth()->id();

        // Xử lý ảnh
        if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
            $path = $this->uploadImage($_FILES['thumbnail']);
            if ($path) $data['thumbnail'] = $path;
        }

        News::create($data);

        return redirect()->route('admin.news.index')->with('success', 'Đăng bài thành công!');
    }

    public function edit(News $news)
    {
        $categories = NewsCategory::orderBy('name')->get();
        return view('admin.news.form', compact('news', 'categories'));
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'nullable|string',
            'status'  => 'required|in:published,draft,scheduled',
        ]);

        $data = $request->only([
            'title', 'slug', 'news_category_id', 'excerpt',
            'content', 'status', 'published_at',
        ]);

        $data['slug'] = $this->makeUniqueSlug(
            !empty($data['slug']) ? $data['slug'] : $data['title'],
            $news->id
        );

        // Xử lý ảnh bằng $_FILES trực tiếp — tránh mọi vấn đề với Laravel Request
        if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
            // Có file upload mới → xóa ảnh cũ, lưu ảnh mới
            $this->deleteImage($news->thumbnail);
            $path = $this->uploadImage($_FILES['thumbnail']);
            if ($path) {
                $data['thumbnail'] = $path;
            }
        } elseif ($request->input('remove_thumbnail') === '1') {
            // Bấm xóa ảnh
            $this->deleteImage($news->thumbnail);
            $data['thumbnail'] = null;
        }
        // Không upload, không xóa → giữ nguyên thumbnail cũ

        $news->update($data);

        return redirect()->route('admin.news.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy(News $news)
    {
        $this->deleteImage($news->thumbnail);
        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'Đã xóa bài viết.');
    }

    // ── Helpers ──────────────────────────────────────────────────────────────

    /**
     * Upload ảnh dùng $_FILES trực tiếp + GD resize
     * Trả về path tương đối: images/news/news_xxx.jpg
     */
    private function uploadImage(array $fileInfo): ?string
    {
        $srcPath = $fileInfo['tmp_name'];

        if (!$srcPath || !file_exists($srcPath)) {
            return null;
        }

        $dir = public_path('images/news');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $filename = 'news_' . time() . '_' . rand(1000, 9999) . '.jpg';
        $destPath = $dir . '/' . $filename;

        // Lấy extension từ mime type để xử lý đúng
        $mime = mime_content_type($srcPath);
        $src  = match ($mime) {
            'image/png'  => @imagecreatefrompng($srcPath),
            'image/webp' => @imagecreatefromwebp($srcPath),
            'image/gif'  => @imagecreatefromgif($srcPath),
            default      => @imagecreatefromjpeg($srcPath),
        };

        // Nếu GD không đọc được → copy thẳng
        if (!$src) {
            copy($srcPath, $destPath);
            return 'images/news/' . $filename;
        }

        $origW = imagesx($src);
        $origH = imagesy($src);
        $maxW  = 1200;

        if ($origW > $maxW) {
            $newW = $maxW;
            $newH = (int) round($origH * $maxW / $origW);
        } else {
            $newW = $origW;
            $newH = $origH;
        }

        $dst = imagecreatetruecolor($newW, $newH);

        // Xử lý transparency (PNG)
        imagealphablending($dst, false);
        imagesavealpha($dst, true);
        imagefilledrectangle($dst, 0, 0, $newW, $newH,
            imagecolorallocatealpha($dst, 255, 255, 255, 127));

        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newW, $newH, $origW, $origH);
        imagejpeg($dst, $destPath, 85);

        imagedestroy($src);
        imagedestroy($dst);

        return 'images/news/' . $filename;
    }

    private function deleteImage(?string $path): void
    {
        if ($path) {
            $full = public_path($path);
            if (file_exists($full)) {
                @unlink($full);
            }
        }
    }

    private function makeUniqueSlug(string $value, ?int $exceptId = null): string
    {
        $base  = Str::slug($value);
        $slug  = $base;
        $count = 1;

        while (
            News::where('slug', $slug)
                ->when($exceptId, fn($q) => $q->where('id', '!=', $exceptId))
                ->exists()
        ) {
            $slug = $base . '-' . $count++;
        }

        return $slug;
    }
}