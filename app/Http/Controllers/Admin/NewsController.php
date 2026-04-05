<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\NewsTag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::with('category', 'author')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where('title', 'like', "%{$q}%");
        }

        $newsList   = $query->paginate(15)->withQueryString();
        $categories = NewsCategory::all();

        return view('admin.news.index', compact('newsList', 'categories'));
    }

    public function create()
    {
        $categories = NewsCategory::all();
        $tags       = NewsTag::all();
        return view('admin.news.form', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'            => 'required|string|max:255',
            'slug'             => 'nullable|string|max:255|unique:news,slug',
            'news_category_id' => 'nullable|exists:news_categories,id',
            'excerpt'          => 'nullable|string|max:500',
            'content'          => 'required|string',
            'thumbnail'        => 'nullable|image|max:2048',
            'status'           => 'required|in:draft,published',
            'tags'             => 'nullable|array',
            'tags.*'           => 'exists:news_tags,id',
        ]);

        $data['user_id'] = Auth::id();
        $data['slug']    = $data['slug'] ?? Str::slug($data['title']);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')
                ->store('news/thumbnails', 'public');
        }

        $news = News::create($data);

        if ($request->filled('tags')) {
            $news->tags()->sync($request->tags);
        }

        return redirect()->route('admin.news.index')
            ->with('success', 'Bài viết đã được tạo thành công!');
    }

    public function edit(News $news)
    {
        $categories = NewsCategory::all();
        $tags       = NewsTag::all();
        return view('admin.news.form', compact('news', 'categories', 'tags'));
    }

    public function update(Request $request, News $news)
    {
        $data = $request->validate([
            'title'            => 'required|string|max:255',
            'slug'             => "nullable|string|max:255|unique:news,slug,{$news->id}",
            'news_category_id' => 'nullable|exists:news_categories,id',
            'excerpt'          => 'nullable|string|max:500',
            'content'          => 'required|string',
            'thumbnail'        => 'nullable|image|max:2048',
            'status'           => 'required|in:draft,published',
            'tags'             => 'nullable|array',
            'tags.*'           => 'exists:news_tags,id',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($news->thumbnail) {
                Storage::disk('public')->delete($news->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')
                ->store('news/thumbnails', 'public');
        }

        $news->update($data);
        $news->tags()->sync($request->tags ?? []);

        return redirect()->route('admin.news.index')
            ->with('success', 'Bài viết đã được cập nhật!');
    }

    public function destroy(News $news)
    {
        if ($news->thumbnail) {
            Storage::disk('public')->delete($news->thumbnail);
        }
        $news->tags()->detach();
        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'Đã xóa bài viết.');
    }

    public function toggleStatus(News $news)
    {
        $news->update([
            'status'       => $news->status === 'published' ? 'draft' : 'published',
            'published_at' => $news->status === 'draft' ? now() : $news->published_at,
        ]);

        return response()->json([
            'status'  => $news->status,
            'message' => $news->status === 'published' ? 'Đã xuất bản' : 'Đã chuyển về bản nháp',
        ]);
    }

    public function categories()
    {
        $categories = NewsCategory::withCount('news')->get();
        return view('admin.news.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100|unique:news_categories,name',
            'slug' => 'nullable|string|max:100|unique:news_categories,slug',
        ]);
        NewsCategory::create($data);
        return back()->with('success', 'Đã thêm chuyên mục!');
    }

    public function destroyCategory(NewsCategory $category)
    {
        $category->delete();
        return back()->with('success', 'Đã xóa chuyên mục.');
    }

    public function tags()
    {
        $tags = NewsTag::withCount('news')->get();
        return view('admin.news.tags', compact('tags'));
    }

    public function storeTag(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100|unique:news_tags,name',
            'slug' => 'nullable|string|max:100|unique:news_tags,slug',
        ]);
        NewsTag::create($data);
        return back()->with('success', 'Đã thêm tag!');
    }

    public function destroyTag(NewsTag $tag)
    {
        $tag->delete();
        return back()->with('success', 'Đã xóa tag.');
    }
}