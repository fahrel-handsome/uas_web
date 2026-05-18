@extends('layout')
@section('title', 'Kelola Modul — Admin CerdasFin')
@section('content')
<div class="container-cf py-10">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.dashboard') }}" class="btn-ghost text-sm">← Admin Panel</a>
        <h1 class="text-2xl font-bold text-rich-black">📚 Kelola Modul</h1>
    </div>
    <div class="card">
        <table class="table-cf">
            <thead><tr><th>Nama Modul</th><th>Kursus</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($modules as $module)
                <tr>
                    <td class="font-medium text-rich-black">{{ $module->title }}</td>
                    <td>{{ $module->courses_count }} kursus</td>
                    <td><span class="{{ $module->is_published ? 'badge-green' : 'badge-gray' }}">{{ $module->is_published ? 'Aktif' : 'Draft' }}</span></td>
                    <td><a href="{{ route('modules.show', $module) }}" class="text-deep-fern-green text-sm hover:underline">Lihat</a></td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center py-8 text-cool-gray">Tidak ada modul</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
