@extends('layout')
@section('title', 'Tambah Materi')
@section('content')
<div class="container-cf py-10 max-w-2xl">
    <a href="{{ route('admin.courses.edit', $course) }}" class="btn-ghost text-sm mb-6 inline-block">← Kembali ke Kursus</a>
    <h1 class="text-2xl font-bold mb-6">Tambah Materi Baru</h1>
    
    <form action="{{ route('admin.courses.lessons.store', $course) }}" method="POST" class="card p-6 space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-bold mb-1">Judul Materi</label>
            <input type="text" name="title" class="w-full border rounded-lg p-2" required>
        </div>
        <div>
            <label class="block text-sm font-bold mb-1">Link Video YouTube (Opsional)</label>
            <input type="url" name="video_url" class="w-full border rounded-lg p-2" placeholder="https://youtube.com/watch?v=...">
            <p class="text-xs text-cool-gray mt-1">Masukkan link video jika ada. User bisa menontonnya saat belajar.</p>
        </div>
        <div>
            <label class="block text-sm font-bold mb-1">Konten / Teks Materi</label>
            <textarea name="content" class="w-full border rounded-lg p-2" rows="6" required placeholder="Gunakan tag HTML dasar seperti <p>, <strong>, dll"></textarea>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold mb-1">Durasi (Menit)</label>
                <input type="number" name="duration_minutes" class="w-full border rounded-lg p-2" required value="10">
            </div>
            <div>
                <label class="block text-sm font-bold mb-1">Urutan (Order)</label>
                <input type="number" name="order" class="w-full border rounded-lg p-2" required value="0">
            </div>
        </div>
        <div>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_published" value="1" checked>
                <span class="text-sm font-bold">Published</span>
            </label>
        </div>
        <button type="submit" class="btn-primary w-full mt-4">Simpan Materi</button>
    </form>
</div>
@endsection
