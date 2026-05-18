@extends('layout')
@section('title', 'Leaderboard — CerdasFin')

@section('content')
<div class="container-cf py-12">

    {{-- Header --}}
    <div class="text-center mb-10">
        <div class="badge-green mb-4 inline-flex">🏆 Kompetisi Belajar</div>
        <h1 class="text-4xl font-bold text-rich-black mb-2">Leaderboard CerdasFin</h1>
        <p class="text-cool-gray text-lg">Siapa yang paling cerdas secara finansial?</p>
        @auth
            @if($myRank)
            <div class="inline-flex items-center gap-2 mt-4 bg-muted-sage px-4 py-2 rounded-full">
                <span class="text-deep-fern-green font-bold">Peringkatmu: #{{ $myRank }}</span>
            </div>
            @endif
        @endauth
    </div>

    {{-- Top 3 Podium --}}
    @if($topUsers->count() >= 3)
    <div class="grid grid-cols-3 gap-4 mb-10 max-w-xl mx-auto items-end">
        {{-- 2nd Place --}}
        <div class="text-center">
            <div class="card p-4 rounded-2xl" style="border-top: 4px solid #c0c0c0;">
                <div class="text-3xl mb-2">🥈</div>
                <div class="avatar mx-auto mb-2">{{ strtoupper(substr($topUsers[1]->user->name ?? 'U', 0, 1)) }}</div>
                <p class="font-bold text-rich-black text-sm truncate">{{ Str::limit($topUsers[1]->user->name ?? '-', 12) }}</p>
                <p class="text-deep-fern-green font-bold">{{ number_format($topUsers[1]->total_points) }}</p>
                <p class="text-xs text-cool-gray">poin</p>
            </div>
        </div>
        {{-- 1st Place --}}
        <div class="text-center -mt-6">
            <div class="card p-4 rounded-2xl shadow-lg" style="border-top: 4px solid #fbbf24;">
                <div class="text-4xl mb-2">🥇</div>
                <div class="avatar w-12 h-12 text-base mx-auto mb-2" style="background:#fbbf24; color:#000;">{{ strtoupper(substr($topUsers[0]->user->name ?? 'U', 0, 1)) }}</div>
                <p class="font-bold text-rich-black text-sm truncate">{{ Str::limit($topUsers[0]->user->name ?? '-', 12) }}</p>
                <p class="text-2xl font-bold text-deep-fern-green">{{ number_format($topUsers[0]->total_points) }}</p>
                <p class="text-xs text-cool-gray">poin</p>
            </div>
        </div>
        {{-- 3rd Place --}}
        <div class="text-center mt-4">
            <div class="card p-4 rounded-2xl" style="border-top: 4px solid #cd7f32;">
                <div class="text-3xl mb-2">🥉</div>
                <div class="avatar mx-auto mb-2">{{ strtoupper(substr($topUsers[2]->user->name ?? 'U', 0, 1)) }}</div>
                <p class="font-bold text-rich-black text-sm truncate">{{ Str::limit($topUsers[2]->user->name ?? '-', 12) }}</p>
                <p class="text-deep-fern-green font-bold">{{ number_format($topUsers[2]->total_points) }}</p>
                <p class="text-xs text-cool-gray">poin</p>
            </div>
        </div>
    </div>
    @endif

    {{-- Full Rankings --}}
    <div class="card overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-subtle-ash">
            <h2 class="font-bold text-rich-black">📋 Daftar Lengkap</h2>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach($topUsers as $i => $up)
            @php $rank = $i + 1; $isMe = auth()->check() && auth()->id() === $up->user_id; @endphp
            <div class="flex items-center gap-4 px-6 py-4 {{ $isMe ? 'bg-mint-green-glow' : 'hover:bg-subtle-ash' }} transition-colors">
                {{-- Rank --}}
                <div class="w-8 text-center flex-shrink-0">
                    @if($rank <= 3)
                        <span class="text-xl">{{ ['🥇','🥈','🥉'][$rank-1] }}</span>
                    @else
                        <span class="text-sm font-bold text-cool-gray">#{{ $rank }}</span>
                    @endif
                </div>

                {{-- Avatar --}}
                <div class="avatar flex-shrink-0">{{ strtoupper(substr($up->user->name ?? 'U', 0, 1)) }}</div>

                {{-- Name & Level --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 flex-wrap">
                        <p class="font-semibold text-rich-black text-sm">{{ $up->user->name ?? 'Anonim' }}</p>
                        @if($isMe) <span class="badge-green text-xs">Kamu</span> @endif
                    </div>
                    @php
                        $pts = $up->total_points;
                        $levelLabel = $pts < 100 ? 'Pemula' : ($pts < 300 ? 'Pelajar' : ($pts < 700 ? 'Mahir' : 'Expert'));
                        $levelClass = $pts < 100 ? 'level-pemula' : ($pts < 300 ? 'level-pelajar' : ($pts < 700 ? 'level-mahir' : 'level-expert'));
                    @endphp
                    <span class="{{ $levelClass }} mt-1 inline-flex text-xs">{{ $levelLabel }}</span>
                </div>

                {{-- Points --}}
                <div class="text-right">
                    <p class="font-bold text-deep-fern-green text-lg">{{ number_format($up->total_points) }}</p>
                    <p class="text-xs text-cool-gray">poin</p>
                </div>
            </div>
            @endforeach

            @if($topUsers->isEmpty())
            <div class="text-center py-16">
                <div class="text-5xl mb-4">🏆</div>
                <p class="text-cool-gray">Belum ada data leaderboard.</p>
                <a href="{{ route('courses.index') }}" class="btn-primary mt-4 inline-flex">Mulai Belajar & Kumpulkan Poin</a>
            </div>
            @endif
        </div>
    </div>

    {{-- How to earn points --}}
    <div class="card-mint p-6 rounded-2xl mt-8">
        <h3 class="font-bold text-rich-black mb-4">💡 Cara Mendapatkan Poin</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center text-sm">
            <div class="bg-white/70 p-3 rounded-xl"><p class="text-2xl mb-1">📚</p><p class="font-semibold text-rich-black">+10</p><p class="text-cool-gray">Selesai pelajaran</p></div>
            <div class="bg-white/70 p-3 rounded-xl"><p class="text-2xl mb-1">✅</p><p class="font-semibold text-rich-black">+50</p><p class="text-cool-gray">Lulus quiz</p></div>
            <div class="bg-white/70 p-3 rounded-xl"><p class="text-2xl mb-1">🎯</p><p class="font-semibold text-rich-black">+75</p><p class="text-cool-gray">Lulus post-test</p></div>
            <div class="bg-white/70 p-3 rounded-xl"><p class="text-2xl mb-1">🏆</p><p class="font-semibold text-rich-black">+100</p><p class="text-cool-gray">Raih sertifikat</p></div>
        </div>
    </div>
</div>
@endsection
