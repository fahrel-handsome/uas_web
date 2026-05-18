<?php

namespace App\Http\Controllers;

use App\Models\UserPoints;
use Illuminate\View\View;

class LeaderboardController extends Controller
{
    public function index(): View
    {
        $topUsers = UserPoints::with('user')
            ->orderByDesc('total_points')
            ->limit(50)
            ->get();

        $myRank = null;
        if (auth()->check()) {
            $myPoints = UserPoints::where('user_id', auth()->id())->first();
            if ($myPoints) {
                $myRank = UserPoints::where('total_points', '>', $myPoints->total_points)->count() + 1;
            }
        }

        return view('leaderboard', compact('topUsers', 'myRank'));
    }
}
