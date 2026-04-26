<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * GET /chat
     * Trả về trang chat standalone (load trong popup của layout)
     */
    public function index()
    {
        return view('chat.index');
    }
}