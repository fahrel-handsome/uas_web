<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Module;
use App\Models\Lesson;
use Illuminate\Http\Request;

class AdminCourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('module')->withCount('lessons')->orderBy('module_id')->orderBy('order')->get();
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $modules = Module::all();
        return view('admin.courses.create', compact('modules'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'module_id' => 'required|exists:modules,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'duration_minutes' => 'required|integer',
            'order' => 'required|integer',
            'is_published' => 'boolean',
        ]);
        
        $validated['slug'] = \Illuminate\Support\Str::slug($validated['title']);
        $validated['is_published'] = $request->has('is_published');
        
        Course::create($validated);
        
        return redirect()->route('admin.courses.index')->with('success', 'Kursus berhasil ditambahkan!');
    }

    public function edit(Course $course)
    {
        $modules = Module::all();
        $course->load('lessons');
        return view('admin.courses.edit', compact('course', 'modules'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'module_id' => 'required|exists:modules,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'duration_minutes' => 'required|integer',
            'order' => 'required|integer',
        ]);
        
        $validated['slug'] = \Illuminate\Support\Str::slug($validated['title']);
        $validated['is_published'] = $request->has('is_published');
        
        $course->update($validated);
        
        return redirect()->route('admin.courses.index')->with('success', 'Kursus berhasil diperbarui!');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Kursus berhasil dihapus!');
    }
}
