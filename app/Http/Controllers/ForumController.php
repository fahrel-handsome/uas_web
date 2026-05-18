<?php

namespace App\Http\Controllers;

use App\Models\ForumCategory;
use App\Models\ForumPost;
use App\Models\ForumComment;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ForumController extends Controller
{
    public function index(): View
    {
        $categories = ForumCategory::with('posts')
            ->get();

        return view('forum.index', ['categories' => $categories]);
    }

    public function category(ForumCategory $category): View
    {
        $posts = $category->posts()
            ->with('user')
            ->orderByRaw('is_pinned DESC')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('forum.category', [
            'category' => $category,
            'posts' => $posts
        ]);
    }

    public function show(ForumCategory $category, ForumPost $post): View
    {
        if ($post->forum_category_id !== $category->id) {
            abort(404);
        }

        $post->incrementViews();
        $post->load('user', 'comments.user');

        return view('forum.post', [
            'category' => $category,
            'post' => $post
        ]);
    }

    public function create(ForumCategory $category): View
    {
        return view('forum.create', ['category' => $category]);
    }

    public function store(ForumCategory $category, Request $request): RedirectResponse
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:10'
        ]);

        $post = ForumPost::create([
            'forum_category_id' => $category->id,
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'content' => $validated['content']
        ]);

        auth()->user()->ensureUserPointsExist();
        auth()->user()->userPoints->addPoints(5);

        return redirect()->route('forum.post', [$category, $post]);
    }

    public function comment(ForumCategory $category, ForumPost $post, Request $request): RedirectResponse
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if ($post->forum_category_id !== $category->id || $post->is_closed) {
            abort(403);
        }

        $validated = $request->validate([
            'content' => 'required|string|min:5'
        ]);

        ForumComment::create([
            'forum_post_id' => $post->id,
            'user_id' => auth()->id(),
            'content' => $validated['content']
        ]);

        auth()->user()->ensureUserPointsExist();
        auth()->user()->userPoints->addPoints(3);

        return redirect()->route('forum.post', [$category, $post]);
    }

    public function likeComment(ForumComment $comment): RedirectResponse
    {
        $comment->incrementLikes();
        return back();
    }
}
