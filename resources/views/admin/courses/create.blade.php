@extends('layout')
@section('title', 'Tambah Kursus')
@section('content')
<div class="container-cf py-10 max-w-2xl">
    <a href="{{ route('admin.courses.index') }}" class="btn-ghost text-sm mb-6 inline-block">← Kembali</a>
    <h1 class="text-2xl font-bold mb-6">Tambah Kursus Baru</h1>
    
    <form action="{{ route('admin.courses.store') }}" method="POST" class="card p-6 space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-bold mb-1">Modul Induk</label>
            <select name="module_id" class="w-full border rounded-lg p-2" required>
                @foreach($modules as $module)
                <option value="{{ $module->id }}">{{ $module->title }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-bold mb-1">Judul Kursus</label>
            <input type="text" name="title" class="w-full border rounded-lg p-2" required>
        </div>
        <div>
            <label class="block text-sm font-bold mb-1">Deskripsi</label>
            <textarea name="description" class="w-full border rounded-lg p-2" rows="3" required></textarea>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold mb-1">Durasi (Menit)</label>
                <input type="number" name="duration_minutes" class="w-full border rounded-lg p-2" required min="1" value="15">
            </div>
            <div>
                <label class="block text-sm font-bold mb-1">Urutan (Order)</label>
                <input type="number" name="order" class="w-full border rounded-lg p-2" required value="0">
            </div>
        </div>
        <div>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_published" value="1" checked>
                <span class="text-sm font-bold">Langsung Publish</span>
            </label>
        </div>
        <button type="submit" class="btn-primary w-full mt-4">Simpan Kursus</button>
    </form>
</div>
@endsection
