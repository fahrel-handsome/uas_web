@extends('layout')
@section('title', 'Forum Diskusi — CerdasFin')

@section('content')
<div class="container-cf py-12">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
        <div>
            <div class="badge-green mb-3">💬 Komunitas</div>
            <h1 class="text-4xl font-bold text-rich-black">Forum Diskusi</h1>
            <p class="text-cool-gray mt-1">Belajar bersama, berbagi pengalaman, tanya para ahli</p>
        </div>
        @auth
        <a href="{{ route('forum.index') }}" class="btn-primary text-sm">+ Buat Topik Baru</a>
        @else
        <a href="{{ route('register') }}" class="btn-primary text-sm">Daftar untuk Berdiskusi</a>
        @endauth
    </div>

    {{-- Categories --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($categories as $category)
        <a href="{{ route('forum.category', $category) }}" class="card group hover:shadow-lg transition-shadow duration-300 overflow-hidden">
            <div class="p-6">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-2xl"
                         style="background: #e1fdea;">
                        {{ ['diskusi-umum'=>'💬','tanya-jawab'=>'❓','berbagi-pengalaman'=>'🌟','anti-pinjol-judol'=>'🛡️'][$category->slug] ?? '📂' }}
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-rich-black">{{ $category->posts->count() }}</p>
                        <p class="text-xs text-cool-gray">topik</p>
                    </div>
                </div>
                <h2 class="text-xl font-bold text-rich-black mb-1 group-hover:text-deep-fern-green transition-colors">{{ $category->name }}</h2>
                <p class="text-sm text-cool-gray mb-4">{{ $category->description }}</p>

                @if($category->posts->count() > 0)
                <div class="border-t border-gray-100 pt-3">
                    <p class="text-xs text-cool-gray">Topik terbaru:</p>
                    <p class="text-sm font-medium text-rich-black mt-1 truncate">
                        {{ $category->posts->sortByDesc('created_at')->first()->title ?? '' }}
                    </p>
                </div>
                @endif
            </div>
            <div class="px-6 py-3 bg-mint-green-glow flex items-center justify-between">
                <span class="text-xs font-medium text-deep-fern-green">Masuk ke forum →</span>
                <svg class="w-4 h-4 text-deep-fern-green group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </div>
        </a>
        @empty
        <div class="col-span-2 card p-16 text-center">
            <div class="text-5xl mb-4">💬</div>
            <p class="text-cool-gray">Forum belum tersedia.</p>
        </div>
        @endforelse
    </div>

    {{-- Forum Rules --}}
    <div class="card-mint p-6 rounded-2xl mt-8">
        <h3 class="font-bold text-rich-black mb-3">📜 Aturan Forum</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-cool-gray">
            <div class="flex items-start gap-2"><span class="text-deep-fern-green">✅</span> Gunakan bahasa yang sopan dan saling menghormati</div>
            <div class="flex items-start gap-2"><span class="text-deep-fern-green">✅</span> Hanya bagikan informasi yang akurat dan bisa diverifikasi</div>
            <div class="flex items-start gap-2"><span class="text-red-500">❌</span> Dilarang promosi pinjol ilegal, judi online, atau investasi bodong</div>
        </div>
    </div>
</div>
@endsection
