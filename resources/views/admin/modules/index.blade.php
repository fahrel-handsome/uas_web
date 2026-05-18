@extends('layout')
@section('title', 'Kelola Modul — Admin CerdasFin')

@section('content')
<div class="container-cf py-10">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.dashboard') }}" class="btn-ghost text-sm">← Admin Panel</a>
            <div>
                <h1 class="text-2xl font-bold text-rich-black">📚 Kelola Modul</h1>
                <p class="text-cool-gray text-sm">{{ $modules->count() }} modul terdaftar</p>
            </div>
        </div>
        <a href="{{ route('admin.modules.create') }}" class="btn-primary">+ Tambah Modul</a>
    </div>

    @if(session('success'))
    <div class="alert-success mb-6">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        {{ session('success') }}
    </div>
    @endif

    <div class="card overflow-hidden">
        <table class="table-cf">
            <thead>
                <tr>
                    <th>Urutan</th>
                    <th>Modul</th>
                    <th>YouTube</th>
                    <th>Kursus</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($modules as $module)
                <tr>
                    <td class="text-center font-bold text-cool-gray w-16">{{ $module->order }}</td>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xl" style="background:#e1fdea;">{{ $module->icon ?? '📚' }}</div>
                            <div>
                                <p class="font-semibold text-rich-black">{{ $module->title }}</p>
                                <p class="text-xs text-cool-gray line-clamp-1 max-w-xs">{{ $module->description }}</p>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($module->youtube_embed_url)
                            <a href="{{ $module->youtube_link }}" target="_blank" class="badge-green text-xs">▶ Video</a>
                        @else
                            <span class="badge-gray text-xs">Tidak ada</span>
                        @endif
                    </td>
                    <td class="font-bold text-center">{{ $module->courses_count ?? $module->courses->count() }}</td>
                    <td>
                        <span class="{{ $module->status === 'published' ? 'badge-green' : 'badge-gray' }}">
                            {{ $module->status === 'published' ? '✅ Published' : '📝 Draft' }}
                        </span>
                    </td>
                    <td>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.quizzes.index', $module) }}" class="btn-primary text-xs py-1 px-3">Kelola Soal</a>
                            <a href="{{ route('admin.modules.edit', $module) }}" class="btn-secondary text-xs py-1 px-3">Edit</a>
                            <form method="POST" action="{{ route('admin.modules.destroy', $module) }}" onsubmit="return confirm('Hapus modul ini? Semua kursus di dalamnya akan terpengaruh.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger text-xs py-1 px-3">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-12">
                        <div class="text-4xl mb-3">📚</div>
                        <p class="text-cool-gray mb-4">Belum ada modul</p>
                        <a href="{{ route('admin.modules.create') }}" class="btn-primary text-sm">Tambah Modul Pertama</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
