@extends('layout')
@section('title', $category->name . ' — Forum CerdasFin')

@section('content')
<div class="container-cf py-12">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-cool-gray mb-6">
        <a href="{{ route('forum.index') }}" class="hover:text-deep-fern-green">Forum</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-rich-black font-medium">{{ $category->name }}</span>
    </div>

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-rich-black">{{ $category->name }}</h1>
            <p class="text-cool-gray mt-1">{{ $category->description }}</p>
        </div>
        @auth
        <a href="{{ route('forum.create', $category) }}" class="btn-primary text-sm">+ Buat Topik Baru</a>
        @else
        <a href="{{ route('login') }}" class="btn-secondary text-sm">Masuk untuk Berdiskusi</a>
        @endauth
    </div>

    {{-- Posts List --}}
    <div class="space-y-3">
        @forelse($posts as $post)
        <a href="{{ route('forum.post', [$category, $post]) }}" class="card flex items-start gap-4 p-5 hover:shadow-md transition-shadow group">
            {{-- User Avatar --}}
            <div class="avatar flex-shrink-0">{{ strtoupper(substr($post->user->name ?? 'U', 0, 1)) }}</div>

            {{-- Content --}}
            <div class="flex-1 min-w-0">
                <div class="flex items-start gap-2 flex-wrap">
                    @if($post->is_pinned)
                        <span class="badge-green text-xs">📌 Disematkan</span>
                    @endif
                    @if($post->is_closed)
                        <span class="badge-gray text-xs">🔒 Ditutup</span>
                    @endif
                    <h2 class="font-semibold text-rich-black group-hover:text-deep-fern-green transition-colors">{{ $post->title }}</h2>
                </div>
                <p class="text-sm text-cool-gray mt-1 line-clamp-1">{{ Str::limit(strip_tags($post->content), 120) }}</p>
                <div class="flex items-center gap-4 mt-2 text-xs text-cool-gray">
                    <span>👤 {{ $post->user->name ?? 'Anonim' }}</span>
                    <span>🕐 {{ $post->created_at->diffForHumans() }}</span>
                    <span>💬 {{ $post->comments->count() }} komentar</span>
                    <span>👁️ {{ $post->views ?? 0 }} dilihat</span>
                </div>
            </div>

            {{-- Arrow --}}
            <svg class="w-5 h-5 text-cool-gray group-hover:text-deep-fern-green flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
        @empty
        <div class="card p-16 text-center">
            <div class="text-5xl mb-4">💬</div>
            <h3 class="text-xl font-bold text-rich-black mb-2">Belum Ada Topik</h3>
            <p class="text-cool-gray mb-6">Jadilah yang pertama membuka diskusi!</p>
            @auth
            <a href="{{ route('forum.create', $category) }}" class="btn-primary">Buat Topik Pertama</a>
            @else
            <a href="{{ route('register') }}" class="btn-primary">Daftar & Berdiskusi</a>
            @endauth
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($posts->hasPages())
    <div class="mt-8">{{ $posts->links() }}</div>
    @endif
</div>
@endsection
