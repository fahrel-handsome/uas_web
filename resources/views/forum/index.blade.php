@extends('layout')
@section('title', 'Forum Diskusi — CerdasFin')

@section('content')
<div class="container-cf py-10">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-rich-black">💬 Forum Diskusi</h1>
        <p class="text-cool-gray mt-1">Pilih ruang diskusi untuk bergabung dan berdiskusi</p>
    </div>

    {{-- Category Cards = WA Group List --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-10">
        @forelse($categories as $category)
        <a href="{{ route('forum.category', $category) }}"
           class="flex items-center gap-4 card p-5 hover:shadow-md transition-all group">
            {{-- Group Icon --}}
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-3xl flex-shrink-0"
                 style="background: linear-gradient(135deg, #d1fadf, #e1fdea);">
                @php
                    $icons = ['💰','🚫','🎰','📈','💬','❓'];
                    echo $icons[($loop->index) % count($icons)];
                @endphp
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between gap-2">
                    <p class="font-bold text-rich-black group-hover:text-deep-fern-green transition-colors">{{ $category->name }}</p>
                    <span class="badge-green text-xs flex-shrink-0">{{ $category->posts_count }} pesan</span>
                </div>
                <p class="text-sm text-cool-gray mt-0.5 truncate">{{ $category->description }}</p>
                @if($category->posts->last())
                <p class="text-xs text-cool-gray mt-1 truncate">
                    💬 {{ Str::limit($category->posts->last()->content ?? $category->posts->last()->title, 45) }}
                </p>
                @endif
            </div>
            <svg class="w-5 h-5 text-cool-gray group-hover:text-deep-fern-green flex-shrink-0 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
        @empty
        <div class="col-span-2 text-center py-16 card">
            <div class="text-5xl mb-4">💬</div>
            <p class="text-cool-gray">Forum sedang disiapkan. Cek kembali nanti.</p>
        </div>
        @endforelse
    </div>

    {{-- Community Tips --}}
    <div class="card p-6" style="background: linear-gradient(135deg, #0b7443, #095f38); color:white;">
        <h3 class="font-bold text-lg mb-3">🌟 Panduan Komunitas CerdasFin</h3>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm text-green-100">
            <div>✅ <strong class="text-white">Berbagi pengalaman</strong> nyata seputar literasi keuangan</div>
            <div>🚫 <strong class="text-white">Dilarang promosi</strong> produk keuangan ilegal atau pinjol</div>
            <div>🤝 <strong class="text-white">Hormati sesama</strong> anggota komunitas</div>
        </div>
    </div>
</div>
@endsection
