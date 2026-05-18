@extends('layout')
@section('title', 'Edit Modul — Admin CerdasFin')

@section('content')
<div class="container-cf py-10 max-w-3xl">
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('admin.modules.index') }}" class="btn-ghost text-sm">← Kembali</a>
        <h1 class="text-2xl font-bold text-rich-black">✏️ Edit Modul: {{ $module->title }}</h1>
    </div>

    {{-- YouTube Preview (jika ada link) --}}
    @if($module->youtube_embed_url)
    <div class="card p-6 mb-6">
        <h3 class="font-semibold text-rich-black mb-3">▶ Preview Video YouTube</h3>
        <div class="relative" style="padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 12px;">
            <iframe
                src="{{ $module->youtube_embed_url }}"
                title="{{ $module->title }}"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen
                style="position:absolute; top:0; left:0; width:100%; height:100%; border:0; border-radius:12px;"
            ></iframe>
        </div>
        <p class="text-xs text-cool-gray mt-2">URL saat ini: <span class="font-mono text-deep-fern-green">{{ $module->youtube_link }}</span></p>
    </div>
    @endif

    <div class="card p-8">
        <form method="POST" action="{{ route('admin.modules.update', $module) }}">
            @csrf @method('PUT')
            <div class="space-y-6">

                {{-- Title --}}
                <div>
                    <label class="form-label">Judul Modul <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $module->title) }}" class="form-input @error('title') border-red-400 @enderror" required>
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Icon & Order --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Ikon (Emoji)</label>
                        <input type="text" name="icon" value="{{ old('icon', $module->icon) }}" class="form-input" maxlength="4">
                    </div>
                    <div>
                        <label class="form-label">Urutan</label>
                        <input type="number" name="order" value="{{ old('order', $module->order) }}" class="form-input" min="0">
                    </div>
                </div>

                {{-- Description --}}
                <div>
                    <label class="form-label">Deskripsi Singkat <span class="text-red-500">*</span></label>
                    <textarea name="description" rows="3" class="form-input resize-none @error('description') border-red-400 @enderror" required>{{ old('description', $module->description) }}</textarea>
                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Content --}}
                <div>
                    <label class="form-label">Konten Materi</label>
                    <textarea name="content" rows="8" class="form-input resize-none font-mono text-sm">{{ old('content', $module->content) }}</textarea>
                </div>

                {{-- YouTube Link --}}
                <div>
                    <label class="form-label">Link Video YouTube</label>
                    <input type="url" name="youtube_link" value="{{ old('youtube_link', $module->youtube_link) }}" class="form-input @error('youtube_link') border-red-400 @enderror" placeholder="https://www.youtube.com/watch?v=...">
                    @error('youtube_link') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    @if($module->youtube_embed_url)
                        <p class="text-xs text-deep-fern-green mt-1">✅ Video saat ini valid. Ganti URL di atas untuk mengubahnya.</p>
                    @endif
                </div>

                {{-- Status --}}
                <div>
                    <label class="form-label">Status Publikasi <span class="text-red-500">*</span></label>
                    <select name="status" class="form-input" required>
                        <option value="draft"     {{ old('status', $module->status) === 'draft'     ? 'selected' : '' }}>📝 Draft</option>
                        <option value="published" {{ old('status', $module->status) === 'published' ? 'selected' : '' }}>✅ Published</option>
                    </select>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="btn-primary">💾 Simpan Perubahan</button>
                    <a href="{{ route('admin.modules.index') }}" class="btn-ghost">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
