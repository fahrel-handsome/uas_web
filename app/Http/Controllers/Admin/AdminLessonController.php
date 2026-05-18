<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;

class AdminLessonController extends Controller
{
    public function create(Course $course)
    {
        return view('admin.lessons.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'video_url' => 'nullable|url',
            'duration_minutes' => 'required|integer',
            'order' => 'required|integer',
        ]);
        
        $validated['course_id'] = $course->id;
        $validated['slug'] = \Illuminate\Support\Str::slug($validated['title']);
        $validated['is_published'] = $request->has('is_published');
        
        Lesson::create($validated);
        
        return redirect()->route('admin.courses.edit', $course)->with('success', 'Materi/Video berhasil ditambahkan!');
    }

    public function edit(Course $course, Lesson $lesson)
    {
        return view('admin.lessons.edit', compact('course', 'lesson'));
    }

    public function update(Request $request, Course $course, Lesson $lesson)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'video_url' => 'nullable|url',
            'duration_minutes' => 'required|integer',
            'order' => 'required|integer',
        ]);
        
        $validated['slug'] = \Illuminate\Support\Str::slug($validated['title']);
        $validated['is_published'] = $request->has('is_published');
        
        $lesson->update($validated);
        
        return redirect()->route('admin.courses.edit', $course)->with('success', 'Materi/Video berhasil diperbarui!');
    }

    public function destroy(Course $course, Lesson $lesson)
    {
        $lesson->delete();
        return redirect()->route('admin.courses.edit', $course)->with('success', 'Materi/Video berhasil dihapus!');
    }
}
