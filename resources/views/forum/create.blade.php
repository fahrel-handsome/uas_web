@extends('layout')
@section('title', 'Buat Topik — Forum CerdasFin')

@section('content')
<div class="container-cf py-12 max-w-2xl">
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('forum.category', $category) }}" class="btn-ghost text-sm">← Kembali</a>
        <div>
            <h1 class="text-2xl font-bold text-rich-black">Buat Topik Baru</h1>
            <p class="text-cool-gray text-sm">di kategori <strong>{{ $category->name }}</strong></p>
        </div>
    </div>

    <div class="card p-8">
        <form method="POST" action="{{ route('forum.store', $category) }}">
            @csrf
            <div class="space-y-5">
                <div>
                    <label class="form-label">Judul Topik</label>
                    <input type="text" name="title" class="form-input" placeholder="Tuliskan judul pertanyaan atau topik diskusimu..." required maxlength="255" value="{{ old('title') }}">
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Isi Topik / Pertanyaan</label>
                    <textarea name="content" rows="8" class="form-input resize-none" placeholder="Jelaskan topik atau pertanyaanmu secara detail. Semakin jelas, semakin mudah dijawab!" required minlength="10">{{ old('content') }}</textarea>
                    @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="alert-warning text-sm">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    Kamu akan mendapatkan +5 poin untuk setiap topik yang dibuat!
                </div>
                <div class="flex items-center gap-3">
                    <button type="submit" class="btn-primary">🚀 Posting Topik</button>
                    <a href="{{ route('forum.category', $category) }}" class="btn-ghost">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
