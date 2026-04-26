<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    public function index(Request $request)
    {
        $query = Newsletter::latest();

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $subscribers = $query->paginate(25);
        $totalActive = Newsletter::where('status', 'active')->count();

        return view('admin.newsletter.index', compact('subscribers', 'totalActive'));
    }

    public function destroy(Newsletter $newsletter)
    {
        $newsletter->delete();
        return back()->with('success', 'Đã xóa subscriber.');
    }

    public function send(Request $request)
    {
        $data = $request->validate([
            'subject' => 'required|string|max:255',
            'body'    => 'required|string',
            'target'  => 'required|in:all,active',
        ]);

        $query = Newsletter::query();
        if ($data['target'] === 'active') {
            $query->where('status', 'active');
        }

        $emails = $query->pluck('email');
        $count  = 0;

        foreach ($emails as $email) {
            // Gửi mail — dùng Mail::raw() hoặc Mailable tùy dự án
            Mail::raw($data['body'], function ($msg) use ($email, $data) {
                $msg->to($email)->subject($data['subject']);
            });
            $count++;
        }

        return back()->with('success', "Đã gửi newsletter tới {$count} địa chỉ email.");
    }
}
