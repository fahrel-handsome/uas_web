@extends('layout')
@section('title', 'Tambah Modul — Admin CerdasFin')

@section('content')
<div class="container-cf py-10 max-w-3xl">
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('admin.modules.index') }}" class="btn-ghost text-sm">← Kembali</a>
        <h1 class="text-2xl font-bold text-rich-black">➕ Tambah Modul Baru</h1>
    </div>

    <div class="card p-8">
        <form method="POST" action="{{ route('admin.modules.store') }}">
            @csrf
            <div class="space-y-6">

                {{-- Title --}}
                <div>
                    <label class="form-label">Judul Modul <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" class="form-input @error('title') border-red-400 @enderror" placeholder="Contoh: Dasar Literasi Keuangan" required>
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Icon & Order --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Ikon (Emoji)</label>
                        <input type="text" name="icon" value="{{ old('icon', '📚') }}" class="form-input" maxlength="4" placeholder="📚">
                    </div>
                    <div>
                        <label class="form-label">Urutan</label>
                        <input type="number" name="order" value="{{ old('order', 0) }}" class="form-input" min="0">
                    </div>
                </div>

                {{-- Description --}}
                <div>
                    <label class="form-label">Deskripsi Singkat <span class="text-red-500">*</span></label>
                    <textarea name="description" rows="3" class="form-input resize-none @error('description') border-red-400 @enderror" placeholder="Deskripsi singkat tentang modul ini..." required>{{ old('description') }}</textarea>
                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Content --}}
                <div>
                    <label class="form-label">Konten Materi (HTML diperbolehkan)</label>
                    <textarea name="content" rows="8" class="form-input resize-none font-mono text-sm" placeholder="<p>Isi materi modul...</p>">{{ old('content') }}</textarea>
                </div>

                {{-- YouTube Link --}}
                <div>
                    <label class="form-label">Link Video YouTube</label>
                    <input type="url" name="youtube_link" value="{{ old('youtube_link') }}" class="form-input @error('youtube_link') border-red-400 @enderror" placeholder="https://www.youtube.com/watch?v=...">
                    @error('youtube_link') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    <p class="text-xs text-cool-gray mt-1">Opsional. Masukkan URL YouTube lengkap (youtube.com/watch?v=... atau youtu.be/...)</p>
                </div>

                {{-- Status --}}
                <div>
                    <label class="form-label">Status Publikasi <span class="text-red-500">*</span></label>
                    <select name="status" class="form-input" required>
                        <option value="draft"     {{ old('status') === 'draft'     ? 'selected' : '' }}>📝 Draft (tidak tampil di publik)</option>
                        <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>✅ Published (tampil di publik)</option>
                    </select>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="btn-primary">💾 Simpan Modul</button>
                    <a href="{{ route('admin.modules.index') }}" class="btn-ghost">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
