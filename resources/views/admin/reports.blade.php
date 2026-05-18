@extends('layout')
@section('title', 'Laporan Dampak — Admin CerdasFin')

@section('content')
<div class="container-cf py-10">
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('admin.dashboard') }}" class="btn-ghost text-sm">← Admin Panel</a>
        <h1 class="text-2xl font-bold text-rich-black">📊 Laporan Dampak Edukasi</h1>
    </div>

    <div class="card-mint p-8 rounded-2xl mb-8 text-center">
        <h2 class="text-2xl font-bold text-rich-black mb-2">CerdasFin Impact Report</h2>
        <p class="text-cool-gray">Dampak nyata platform edukasi literasi keuangan untuk masyarakat Indonesia</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="stat-card">
            <div class="text-2xl mb-1">👥</div>
            <div class="stat-number">{{ \App\Models\User::count() }}</div>
            <div class="stat-label">Total Pengguna Terdaftar</div>
        </div>
        <div class="stat-card">
            <div class="text-2xl mb-1">📚</div>
            <div class="stat-number text-deep-fern-green">{{ \App\Models\UserProgress::where('is_completed', true)->count() }}</div>
            <div class="stat-label">Total Penyelesaian Kursus</div>
        </div>
        <div class="stat-card">
            <div class="text-2xl mb-1">🏆</div>
            <div class="stat-number text-terra-cotta">{{ \App\Models\Certificate::count() }}</div>
            <div class="stat-label">Sertifikat Diterbitkan</div>
        </div>
    </div>

    <div class="card p-8">
        <h2 class="font-bold text-rich-black mb-4">📈 Dampak Peningkatan Literasi Keuangan</h2>
        @php
            $scoreData = \App\Models\UserProgress::whereNotNull('score_pre_test')
                ->whereNotNull('score_post_test')
                ->selectRaw('AVG(score_pre_test) as avg_pre, AVG(score_post_test) as avg_post, COUNT(*) as count')
                ->first();
        @endphp
        @if($scoreData && $scoreData->count > 0)
        <div class="grid grid-cols-3 gap-4 mb-4">
            <div class="p-4 bg-melon-tint rounded-xl text-center">
                <p class="text-sm text-cool-gray">Rata-rata Pre-test</p>
                <p class="text-3xl font-bold text-terra-cotta">{{ round($scoreData->avg_pre) }}</p>
            </div>
            <div class="p-4 bg-mint-green-glow rounded-xl text-center">
                <p class="text-sm text-cool-gray">Rata-rata Post-test</p>
                <p class="text-3xl font-bold text-deep-fern-green">{{ round($scoreData->avg_post) }}</p>
            </div>
            <div class="p-4 bg-deep-fern-green text-white rounded-xl text-center">
                <p class="text-sm text-muted-sage">Peningkatan Rata-rata</p>
                <p class="text-3xl font-bold">+{{ round($scoreData->avg_post - $scoreData->avg_pre) }}</p>
            </div>
        </div>
        <div class="alert-success">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            Data dari {{ $scoreData->count }} pengguna yang telah menyelesaikan pre-test dan post-test.
        </div>
        @else
        <div class="text-center py-8 text-cool-gray">
            <p>Belum ada data pre/post-test yang cukup untuk laporan.</p>
        </div>
        @endif
    </div>
</div>
@endsection
