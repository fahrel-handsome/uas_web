@extends('layout')
@section('title', 'Edit Materi')
@section('content')
<div class="container-cf py-10 max-w-2xl">
    <a href="{{ route('admin.courses.edit', $course) }}" class="btn-ghost text-sm mb-6 inline-block">← Kembali ke Kursus</a>
    <h1 class="text-2xl font-bold mb-6">Edit Materi</h1>
    
    <form action="{{ route('admin.courses.lessons.update', [$course, $lesson]) }}" method="POST" class="card p-6 space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-bold mb-1">Judul Materi</label>
            <input type="text" name="title" value="{{ $lesson->title }}" class="w-full border rounded-lg p-2" required>
        </div>
        <div>
            <label class="block text-sm font-bold mb-1">Link Video YouTube (Opsional)</label>
            <input type="url" name="video_url" value="{{ $lesson->video_url }}" class="w-full border rounded-lg p-2" placeholder="https://youtube.com/watch?v=...">
        </div>
        <div>
            <label class="block text-sm font-bold mb-1">Konten / Teks Materi</label>
            <textarea name="content" class="w-full border rounded-lg p-2" rows="6" required>{{ $lesson->content }}</textarea>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold mb-1">Durasi (Menit)</label>
                <input type="number" name="duration_minutes" value="{{ $lesson->duration_minutes }}" class="w-full border rounded-lg p-2" required>
            </div>
            <div>
                <label class="block text-sm font-bold mb-1">Urutan (Order)</label>
                <input type="number" name="order" value="{{ $lesson->order }}" class="w-full border rounded-lg p-2" required>
            </div>
        </div>
        <div>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_published" value="1" {{ $lesson->is_published ? 'checked' : '' }}>
                <span class="text-sm font-bold">Published</span>
            </label>
        </div>
        <button type="submit" class="btn-primary w-full mt-4">Simpan Perubahan</button>
    </form>
</div>
@endsection
