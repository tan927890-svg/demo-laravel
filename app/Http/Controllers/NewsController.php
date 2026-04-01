<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        return view('news'); // gọi file resources/views/news.blade.php
    }

    public function show($slug)
    {
        return "Chi tiết bài viết: " . $slug;
    }
}