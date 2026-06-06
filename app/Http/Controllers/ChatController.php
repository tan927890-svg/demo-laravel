<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Models\CarGallery;

class ChatController extends Controller
{
    /**
     * URL của Python chatbot service.
     * Đặt trong .env: CHATBOT_API_URL=http://127.0.0.1:8000
     */
    private string $apiUrl;

    public function __construct()
    {
        // ✅ FIX 1: ép dùng 127.0.0.1 thay vì localhost để tránh lỗi IPv6 trên Windows
        $url = rtrim(env('CHATBOT_API_URL', 'http://127.0.0.1:8000'), '/');
        $this->apiUrl = str_replace('http://localhost', 'http://127.0.0.1', $url);
    }

    // ── Keywords kích hoạt tìm video ──────────────────────────────────────
    private array $videoKeywords = [
        'video', 'phim', 'xem phim', 'official film', 'film', 'clip',
        'youtube', 'xem video', 'cho xem', 'link video', 'link xem',
    ];

    // ── Keywords kích hoạt hiển thị form đặt lịch ────────────────────────
    private array $bookingKeywords = [
        'đặt lịch', 'lái thử', 'test drive', 'đặt hẹn', 'hẹn lịch',
        'book', 'lịch hẹn', 'muốn thử', 'cho tôi thử',
        'đăng ký lái', 'đăng ký thử',
    ];

    private function isVideoRequest(string $text): bool
    {
        $lower = mb_strtolower($text, 'UTF-8');
        foreach ($this->videoKeywords as $kw) {
            if (str_contains($lower, $kw)) return true;
        }
        return false;
    }

    private function isBookingRequest(string $text): bool
    {
        $lower = mb_strtolower($text, 'UTF-8');
        foreach ($this->bookingKeywords as $kw) {
            if (str_contains($lower, $kw)) return true;
        }
        return false;
    }

    // ── Tìm video trong DB theo tên xe ───────────────────────────────────
    private function findVideos(string $text): array
    {
        $lower  = mb_strtolower($text, 'UTF-8');
        $videos = CarGallery::where('type', 'video')
            ->whereNotNull('file_path')
            ->with('car:id,name')
            ->get();

        $matched = $videos->filter(function ($v) use ($lower) {
            $carName = mb_strtolower($v->car?->name ?? '', 'UTF-8');
            if (!$carName) return false;
            foreach (explode(' ', $carName) as $word) {
                if (strlen($word) >= 3 && str_contains($lower, $word)) return true;
            }
            return false;
        });

        return [
            'videos'  => $matched->count() > 0 ? $matched : collect(),
            'matched' => $matched->count() > 0,
            'all'     => $videos,
        ];
    }

    // ── Xử lý trả video (dùng chung cho 2 luồng) ─────────────────────────
    private function handleVideoResponse(string $message): \Illuminate\Http\JsonResponse
    {
        $result  = $this->findVideos($message);
        $matched = $result['matched'];
        $videos  = $result['videos'];
        $all     = $result['all'];

        if (!$matched) {
            $carNames = $all
                ->map(fn($v) => $v->car?->name)
                ->filter()->unique()->values()->join(', ');

            Session::put('awaiting_video_car', true);

            return response()->json([
                'status'   => 'success',
                'response' => "Bạn muốn xem video dòng xe nào? 🎬\n\nChúng tôi có video chính thức của: {$carNames}\n\nVui lòng gõ tên dòng xe cụ thể nhé!",
            ]);
        }

        Session::forget('awaiting_video_car');

        $lines = $videos->map(function ($v) {
            $name    = $v->car?->name ?? 'Mercedes';
            $caption = $v->caption ?: $name . ' – Official Film';
            return "🎬 {$caption}\n{$v->file_path}";
        })->join("\n\n");

        $intro = $videos->count() === 1
            ? "Đây là video chính thức của dòng xe bạn quan tâm 🎬"
            : "Đây là các video chính thức phù hợp với yêu cầu của bạn 🎬";

        $matchedCarIds = $videos->pluck('car_id')->filter()->unique();
        $otherCarNames = $all
            ->filter(fn($v) => !$matchedCarIds->contains($v->car_id))
            ->map(fn($v) => $v->car?->name)
            ->filter()->unique()->values();

        $suffix = $otherCarNames->isNotEmpty()
            ? "\n\n---\nChúng tôi còn video của: " . $otherCarNames->join(', ') . "\nBạn có muốn xem không? 😊"
            : '';

        return response()->json([
            'status'   => 'success',
            'type'     => 'video_links',
            'response' => $intro . "\n\n" . $lines . $suffix,
        ]);
    }

    // ── Gọi Python chatbot service ────────────────────────────────────────
    private function callPythonChat(string $message, string $sessionId): \Illuminate\Http\JsonResponse
    {
        try {
            $response = Http::timeout(30)
                ->retry(2, 1000)
                ->post("{$this->apiUrl}/chat", [
                    'message'    => $message,
                    'session_id' => $sessionId,
                ]);

            if (!$response->successful()) {
                $status = $response->status();
                \Log::error("Python chatbot error [{$status}]: " . $response->body());

                $msg = match ($status) {
                    503     => 'AI service đang khởi động, vui lòng thử lại sau.',
                    429     => 'Hệ thống đang bận, vui lòng thử lại sau ít phút.',
                    default => "Không kết nối được AI (lỗi {$status}). Vui lòng thử lại sau.",
                };

                return response()->json(['status' => 'error', 'response' => $msg]);
            }

            return response()->json($response->json());

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            \Log::error('Python chatbot timeout: ' . $e->getMessage());
            return response()->json([
                'status'   => 'error',
                'response' => 'Kết nối đến AI bị timeout. Vui lòng thử lại.',
            ]);
        } catch (\Exception $e) {
            \Log::error('ChatController error: ' . $e->getMessage());
            return response()->json([
                'status'   => 'error',
                'response' => 'Có lỗi xảy ra, vui lòng thử lại.',
            ]);
        }
    }

    // ── Gọi Python vision service (xử lý ảnh xe) ─────────────────────────
    private function callPythonImage(string $imageB64, string $mediaType, string $sessionId): \Illuminate\Http\JsonResponse
    {
        try {
            $response = Http::timeout(60)
                ->retry(2, 2000)
                ->post("{$this->apiUrl}/chat/image", [
                    'image_b64'  => $imageB64,
                    'media_type' => $mediaType,
                    'session_id' => $sessionId,
                ]);

            if (!$response->successful()) {
                \Log::error("Python vision error [{$response->status()}]: " . $response->body());
                return response()->json([
                    'status'   => 'error',
                    'response' => 'Không thể phân tích ảnh lúc này. Vui lòng thử lại.',
                ]);
            }

            return response()->json($response->json());

        } catch (\Exception $e) {
            \Log::error('Vision error: ' . $e->getMessage());
            return response()->json([
                'status'   => 'error',
                'response' => 'Có lỗi xảy ra khi xử lý ảnh.',
            ]);
        }
    }

    // =========================================================================
    // Routes
    // =========================================================================

    /**
     * GET /chat
     */
    public function index()
    {
        return view('chat.index');
    }

    /**
     * POST /chat  — tin nhắn text
     */
    public function send(Request $request)
    {
        $message = trim($request->input('message', ''));

        // ✅ FIX 2: ưu tiên session_id từ frontend (browser tab),
        //           fallback về Laravel session nếu không có
        $sessionId = $request->input('session_id') ?: $request->session()->getId();

        if (!$message) {
            return response()->json([
                'status'   => 'error',
                'response' => 'Vui lòng nhập câu hỏi.',
            ]);
        }

        // ① Đang chờ khách gõ tên xe để xem video
        if (Session::get('awaiting_video_car', false)) {
            return $this->handleVideoResponse($message);
        }

        // ② Khách hỏi video
        if ($this->isVideoRequest($message)) {
            return $this->handleVideoResponse($message);
        }

        // ③ Khách muốn đặt lịch → trả form
        if ($this->isBookingRequest($message)) {
            return response()->json([
                'status'   => 'success',
                'type'     => 'booking_form',
                'response' => 'Vui lòng điền thông tin bên dưới để đặt lịch lái thử. Chúng tôi sẽ xác nhận trong vòng 30 phút! 🚗',
            ]);
        }

        // ④ Mọi câu hỏi còn lại → gọi Python chatbot service
        return $this->callPythonChat($message, $sessionId);
    }

    /**
     * POST /chat/image  — khách gửi ảnh xe
     */
    public function sendImage(Request $request)
    {
        // ✅ FIX 2 (áp dụng cả sendImage)
        $sessionId = $request->input('session_id') ?: $request->session()->getId();

        if ($request->hasFile('image')) {
            $file      = $request->file('image');
            $imageB64  = base64_encode(file_get_contents($file->getRealPath()));
            $mediaType = $file->getMimeType() ?: 'image/jpeg';
        } elseif ($request->input('image_b64')) {
            $imageB64  = $request->input('image_b64');
            $mediaType = $request->input('media_type', 'image/jpeg');
        } else {
            return response()->json([
                'status'   => 'error',
                'response' => 'Vui lòng gửi ảnh hợp lệ.',
            ]);
        }

        return $this->callPythonImage($imageB64, $mediaType, $sessionId);
    }

    /**
     * POST /chat/clear  — xóa lịch sử hội thoại
     */
    public function clearSession(Request $request)
    {
        // ✅ FIX 2 (áp dụng cả clearSession)
        $sessionId = $request->input('session_id') ?: $request->session()->getId();
        Session::forget('awaiting_video_car');

        Http::timeout(5)->post("{$this->apiUrl}/chat/clear", [
            'session_id' => $sessionId,
        ]);

        return response()->json(['status' => 'ok']);
    }
}