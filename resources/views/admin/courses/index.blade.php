@extends('layout')
@section('title', 'Kelola Kursus — Admin CerdasFin')
@section('content')
<div class="container-cf py-10">
    <div class="flex items-center justify-between mb-8">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="btn-ghost text-sm mb-2 inline-block">← Admin Panel</a>
            <h1 class="text-2xl font-bold">📚 Kelola Kursus & Video</h1>
        </div>
        <a href="{{ route('admin.courses.create') }}" class="btn-primary">+ Tambah Kursus</a>
    </div>

    @if(session('success'))
    <div class="alert-success mb-6">{{ session('success') }}</div>
    @endif

    <div class="card overflow-hidden">
        <table class="table-cf">
            <thead>
                <tr>
                    <th>Modul</th>
                    <th>Kursus</th>
                    <th>Materi / Video</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($courses as $course)
                <tr>
                    <td class="text-sm font-semibold">{{ $course->module->title ?? '-' }}</td>
                    <td>
                        <p class="font-bold">{{ $course->title }}</p>
                        <p class="text-xs text-cool-gray">{{ $course->duration_minutes }} menit</p>
                    </td>
                    <td class="text-center font-bold">{{ $course->lessons_count }} Materi</td>
                    <td>
                        <span class="{{ $course->is_published ? 'badge-green' : 'badge-gray' }}">
                            {{ $course->is_published ? 'Published' : 'Draft' }}
                        </span>
                    </td>
                    <td>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.courses.edit', $course) }}" class="btn-secondary text-xs py-1 px-3">Kelola / Edit</a>
                            <form method="POST" action="{{ route('admin.courses.destroy', $course) }}" onsubmit="return confirm('Hapus kursus ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger text-xs py-1 px-3">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
