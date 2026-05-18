@extends('layout')
@section('title', 'Edit Kursus')
@section('content')
<div class="container-cf py-10">
    <a href="{{ route('admin.courses.index') }}" class="btn-ghost text-sm mb-6 inline-block">← Kembali</a>
    
    @if(session('success'))
    <div class="alert-success mb-6">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Edit Form -->
        <div class="lg:col-span-1">
            <h1 class="text-xl font-bold mb-4">Detail Kursus</h1>
            <form action="{{ route('admin.courses.update', $course) }}" method="POST" class="card p-6 space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-sm font-bold mb-1">Modul Induk</label>
                    <select name="module_id" class="w-full border rounded-lg p-2" required>
                        @foreach($modules as $module)
                        <option value="{{ $module->id }}" {{ $course->module_id == $module->id ? 'selected' : '' }}>{{ $module->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-1">Judul Kursus</label>
                    <input type="text" name="title" value="{{ $course->title }}" class="w-full border rounded-lg p-2" required>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-1">Deskripsi</label>
                    <textarea name="description" class="w-full border rounded-lg p-2" rows="3" required>{{ $course->description }}</textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold mb-1">Durasi</label>
                        <input type="number" name="duration_minutes" value="{{ $course->duration_minutes }}" class="w-full border rounded-lg p-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-1">Urutan</label>
                        <input type="number" name="order" value="{{ $course->order }}" class="w-full border rounded-lg p-2" required>
                    </div>
                </div>
                <div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_published" value="1" {{ $course->is_published ? 'checked' : '' }}>
                        <span class="text-sm font-bold">Published</span>
                    </label>
                </div>
                <button type="submit" class="btn-primary w-full mt-4">Simpan Perubahan</button>
            </form>
        </div>

        <!-- Lessons / Video -->
        <div class="lg:col-span-2">
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-xl font-bold">Materi / Video</h1>
                <a href="{{ route('admin.courses.lessons.create', $course) }}" class="btn-primary text-sm">+ Tambah Materi</a>
            </div>
            <div class="card overflow-hidden">
                <table class="table-cf">
                    <thead>
                        <tr>
                            <th>Urutan</th>
                            <th>Materi</th>
                            <th>Video / Teks</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($course->lessons as $lesson)
                        <tr>
                            <td class="text-center font-bold">{{ $lesson->order }}</td>
                            <td>
                                <p class="font-bold text-sm">{{ $lesson->title }}</p>
                                <p class="text-xs text-cool-gray">{{ $lesson->duration_minutes }} menit</p>
                            </td>
                            <td>
                                @if($lesson->video_url)
                                    <a href="{{ $lesson->video_url }}" target="_blank" class="badge-green text-xs">▶ Ada Video</a>
                                @else
                                    <span class="badge-gray text-xs">Teks Saja</span>
                                @endif
                            </td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.courses.lessons.edit', [$course, $lesson]) }}" class="btn-secondary text-xs py-1 px-3">Edit</a>
                                    <form method="POST" action="{{ route('admin.courses.lessons.destroy', [$course, $lesson]) }}" onsubmit="return confirm('Hapus materi ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-danger text-xs py-1 px-3">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-6 text-cool-gray">Belum ada materi/video di kursus ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
