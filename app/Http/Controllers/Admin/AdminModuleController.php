<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Course;
use Illuminate\View\View;

class AdminModuleController extends Controller
{
    public function index(): View
    {
        $modules = Module::withCount('courses')
            ->orderBy('order')
            ->get();

        return view('admin.modules.index', compact('modules'));
    }
}
