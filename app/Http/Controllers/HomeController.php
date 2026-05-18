<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Course;
use App\Models\UserProgress;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $modules = Module::where('is_published', true)
            ->with('courses')
            ->get();
        
        $popularCourses = Course::where('is_published', true)
            ->with('module')
            ->limit(6)
            ->get();

        return view('welcome', [
            'modules' => $modules,
            'popularCourses' => $popularCourses
        ]);
    }
}
