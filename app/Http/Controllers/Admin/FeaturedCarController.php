<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class FeaturedCarController extends Controller
{
    /**
     * Danh sách xe nổi bật (is_featured = true)
     */
    public function index()
    {
        $featured = Car::where('is_featured', true)
                       ->orderBy('name')
                       ->get();

        $available = Car::where('is_featured', false)
                        ->orderBy('name')
                        ->get();

        return view('admin.featured-cars.index', compact('featured', 'available'));
    }

    /**
     * Form chỉnh sửa xe nổi bật (badge + 8 ảnh 360°)
     */
    public function edit(Car $car)
    {
        $frames = $this->getExistingFrames($car);

        return view('admin.featured-cars.edit', compact('car', 'frames'));
    }

    /**
     * Lưu badge + đánh dấu xe là nổi bật
     */
    public function markFeatured(Request $request, Car $car)
    {
        $request->validate([
            'badge_label' => 'nullable|string|max:60',
        ]);

        $car->update([
            'is_featured' => true,
            'badge_label' => $request->badge_label ?? '',
        ]);

        return back()->with('success', "Đã đánh dấu {$car->name} là xe nổi bật.");
    }

    /**
     * Bỏ xe nổi bật
     */
    public function unmarkFeatured(Car $car)
    {
        $car->update(['is_featured' => false]);

        return back()->with('success', "Đã bỏ {$car->name} khỏi danh sách xe nổi bật.");
    }

    /**
     * Upload/cập nhật ảnh 360° (tối đa 8 frame)
     */
    public function update360(Request $request, Car $car)
    {
        $request->validate([
            'frames'          => 'required|array|min:1|max:8',
            'frames.*'        => 'required|image|mimes:png,jpg,jpeg,webp|max:5120',
            'frame_indices'   => 'nullable|array',
            'frame_indices.*' => 'nullable|integer|min:0',
        ]);

        // Thư mục lưu ảnh theo slug tên xe
        $slug   = Str::slug($car->name);
        $folder = public_path('images/quay360/' . $slug . '/');
        @mkdir($folder, 0775, true);

        $files   = $request->file('frames');
        $indices = $request->input('frame_indices', []);

        foreach ($files as $i => $file) {
            // frame_indices[i] là 0-based → +1 để thành 1-based
            $frameNum = isset($indices[$i]) ? (int)$indices[$i] + 1 : $i + 1;

            // Đảm bảo trong khoảng 1-8
            $frameNum = max(1, min(8, $frameNum));

            $filename = $frameNum . '.png';
            $file->move($folder, $filename);
        }

        // Cập nhật DB
        $car->update([
            'image_360_prefix' => asset('images/quay360/' . $slug . '/'),
            'image_360_frames' => 8,
            'is_featured'      => true,
        ]);

        return back()->with('success', 'Đã upload ảnh 360° thành công!');
    }

    /**
     * Xoá 1 frame cụ thể
     */
    public function deleteFrame(Car $car, int $frameNum): RedirectResponse
    {
        $folder   = public_path('images/quay360/' . Str::slug($car->name) . '/');
        $filePath = $folder . $frameNum . '.png';

        if (file_exists($filePath)) {
            unlink($filePath);
        }

        return back()->with('success', "Đã xoá frame #{$frameNum}.");
    }

    /**
     * Xoá nhiều frame cùng lúc
     * DELETE /admin/featured-cars/{car}/frames
     * Body: frames[] = [1, 3, 5, ...]
     */
    public function deleteFrames(Request $request, Car $car): RedirectResponse
    {
        $frames = $request->input('frames', []);

        if (empty($frames)) {
            return back()->with('error', 'Vui lòng chọn ít nhất 1 frame để xoá.');
        }

        $folder  = public_path('images/quay360/' . Str::slug($car->name) . '/');
        $deleted = 0;

        foreach ($frames as $frame) {
            $frame = (int) $frame;
            if ($frame < 1 || $frame > 8) continue;

            $path = $folder . $frame . '.png';
            if (file_exists($path)) {
                unlink($path);
                $deleted++;
            }
        }

        return back()->with('success', "Đã xoá {$deleted} frame thành công.");
    }

    /**
     * Trả về danh sách frame đã tồn tại trên disk
     */
    private function getExistingFrames(Car $car): array
    {
        $slug   = Str::slug($car->name);
        $folder = public_path('images/quay360/' . $slug . '/');
        $frames = [];

        for ($i = 1; $i <= 8; $i++) {
            $path       = $folder . $i . '.png';
            $exists     = file_exists($path);
            $frames[$i] = [
                'exists' => $exists,
                'url'    => $exists
                            ? asset('images/quay360/' . $slug . '/' . $i . '.png') . '?t=' . filemtime($path)
                            : null,
            ];
        }

        return $frames;
    }
}