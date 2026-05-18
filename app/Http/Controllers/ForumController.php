<?php

namespace App\Http\Controllers;

use App\Models\ForumCategory;
use App\Models\ForumPost;
use App\Models\ForumComment;
use App\Services\GamificationService;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ForumController extends Controller
{
    public function __construct(
        private readonly GamificationService $gamification
    ) {}

    // ─── Forum Home — list categories as "group chats" ─────
    public function index(): View
    {
        $categories = ForumCategory::withCount('posts')
            ->orderBy('order')
            ->get();

        // Recent messages across all categories
        $recentMessages = ForumPost::with(['user', 'category'])
            ->latest()
            ->limit(5)
            ->get();

        return view('forum.index', compact('categories', 'recentMessages'));
    }

    // ─── Category Chat Room — WhatsApp-style group chat ────
    public function category(ForumCategory $category): View
    {
        // Load ALL messages (posts) + their replies (comments) as chat bubbles
        $messages = ForumPost::where('forum_category_id', $category->id)
            ->with(['user', 'comments' => fn($q) => $q->with('user')->orderBy('created_at')])
            ->orderBy('created_at', 'asc')  // oldest first (chat style)
            ->get();

        return view('forum.category', compact('category', 'messages'));
    }

    // ─── Send a new message (post) in a category ───────────
    public function store(ForumCategory $category, Request $request): RedirectResponse
    {
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('warning', 'Silakan masuk untuk mengirim pesan.');
        }

        $validated = $request->validate([
            'content' => 'required|string|min:2|max:2000',
        ]);

        $post = ForumPost::create([
            'forum_category_id' => $category->id,
            'user_id'           => auth()->id(),
            'title'             => Str::limit($validated['content'], 60),
            'slug'              => Str::slug(Str::limit($validated['content'], 50)) . '-' . time(),
            'content'           => $validated['content'],
        ]);

        // Award points
        if (auth()->check()) {
            auth()->user()->ensureUserPointsExist();
            $this->gamification->awardPoints(auth()->user(), 'forum_post');
        }

        return redirect()->route('forum.category', $category)
            ->with('success', 'Pesan terkirim! +5 poin')
            ->withFragment('msg-' . $post->id);
    }

    // ─── Reply to a message ─────────────────────────────────
    public function comment(ForumCategory $category, ForumPost $post, Request $request): RedirectResponse
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if ($post->forum_category_id !== $category->id || $post->is_closed) {
            abort(403, 'Tidak dapat membalas pesan ini.');
        }

        $validated = $request->validate([
            'content' => 'required|string|min:2|max:1000',
        ]);

        ForumComment::create([
            'forum_post_id' => $post->id,
            'user_id'       => auth()->id(),
            'content'       => $validated['content'],
        ]);

        if (auth()->check()) {
            auth()->user()->ensureUserPointsExist();
            $this->gamification->awardPoints(auth()->user(), 'forum_comment');
        }

        return redirect()->route('forum.category', $category)
            ->withFragment('msg-' . $post->id);
    }

    // ─── Individual post view (kept for backward compat) ───
    public function show(ForumCategory $category, ForumPost $post): View
    {
        if ($post->forum_category_id !== $category->id) abort(404);

        $post->incrementViews();
        $post->load('user', 'comments.user');

        return view('forum.post', compact('category', 'post'));
    }

    // ─── Create form (kept for backward compat) ─────────────
    public function create(ForumCategory $category): View
    {
        return redirect()->route('forum.category', $category);
    }
}
