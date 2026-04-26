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

        // Dùng get() + collection thay vì paginate() để slice() hoạt động
        $latestNews = News::published()->byDate()->limit(6)->get(); // tăng từ 3 lên 6
        $popularPosts = News::published()->popular()->limit(5)->get();
        $recentPosts  = News::published()->byDate()->limit(5)->get();
        $tags         = NewsTag::all();
        $totalCount   = News::published()->count();

        $coverStory = News::published()
            ->with('category', 'author')
            ->where('is_cover', true)
            ->byDate()
            ->first()
            ?? News::published()->with('category', 'author')->byDate()->first();

        $categoryCounts = NewsCategory::withCount(['news' => function ($q) {
            $q->published();
        }])->get()->pluck('news_count', 'slug');

        return view('news', compact(
            'latestNews',
            'popularPosts',
            'recentPosts',
            'tags',
            'totalCount',
            'coverStory',
            'categoryCounts'
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
            ->byDate()
            ->limit(3)
            ->get();

        return view('news-show', compact('post', 'related'));
    }
}