<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\UserProgress;
use App\Models\Certificate;
use App\Models\ForumPost;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_users'       => User::count(),
            'active_users'      => User::whereHas('progressData')->count(),
            'total_completions' => UserProgress::where('is_completed', true)->count(),
            'certificates'      => Certificate::count(),
            'forum_posts'       => ForumPost::count(),
        ];

        $recentUsers = User::latest()->limit(10)->get();

        // Score improvement data: avg pre vs post
        $scoreData = UserProgress::whereNotNull('score_pre_test')
            ->whereNotNull('score_post_test')
            ->selectRaw('AVG(score_pre_test) as avg_pre, AVG(score_post_test) as avg_post')
            ->first();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'scoreData'));
    }

    public function reports(): View
    {
        return view('admin.reports');
    }
}
