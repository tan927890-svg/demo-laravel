<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\NewsTag;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::published()->with('category', 'tags');

        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        if ($request->filled('tag')) {
            $query->byTag($request->tag);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('excerpt', 'like', "%{$q}%");
            });
        }

        $latestNews   = (clone $query)->byDate()->paginate(6);  // ✅ đổi từ latest()
        $popularPosts = News::published()->popular()->limit(5)->get();
        $recentPosts  = News::published()->byDate()->limit(5)->get();  // ✅ đổi từ latest()
        $tags         = NewsTag::all();
        $totalPosts   = News::published()->count();

        return view('news', compact(
            'latestNews',
            'popularPosts',
            'recentPosts',
            'tags',
            'totalPosts'
        ));
    }

    public function show(string $slug)
    {
        $post = News::published()
            ->with('category', 'author', 'tags')
            ->where('slug', $slug)
            ->firstOrFail();

        $post->incrementViews();

        $related = News::published()
            ->where('id', '!=', $post->id)
            ->where('news_category_id', $post->news_category_id)
            ->byDate()  // ✅ đổi từ latest()
            ->limit(3)
            ->get();

        return view('news-show', compact('post', 'related'));
    }
}