<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Course;
use Illuminate\View\View;

class ModuleController extends Controller
{
    public function index(): View
    {
        $modules = Module::where('is_published', true)
            ->withCount('courses')
            ->orderBy('order')
            ->get();

        return view('modules.index', compact('modules'));
    }

    public function show(Module $module): View
    {
        $module->load(['courses' => function ($q) {
            $q->where('is_published', true)->orderBy('order');
        }]);

        $userProgress = [];
        if (auth()->check()) {
            $userProgress = \App\Models\UserProgress::where('user_id', auth()->id())
                ->whereIn('course_id', $module->courses->pluck('id'))
                ->get()
                ->keyBy('course_id');
        }

        return view('modules.show', compact('module', 'userProgress'));
    }
}
