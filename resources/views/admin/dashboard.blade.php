@extends('layout')
@section('title', 'Admin Panel — CerdasFin')

@section('content')
<div class="container-cf py-10">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-rich-black">⚙️ Admin Panel</h1>
            <p class="text-cool-gray">Kelola platform CerdasFin</p>
        </div>
        <div class="badge-peach">{{ Auth::user()->name }} — Admin</div>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
        <div class="stat-card"><div class="text-2xl mb-1">👥</div><div class="stat-number">{{ $stats['total_users'] }}</div><div class="stat-label">Total User</div></div>
        <div class="stat-card"><div class="text-2xl mb-1">📊</div><div class="stat-number text-deep-fern-green">{{ $stats['active_users'] }}</div><div class="stat-label">User Aktif</div></div>
        <div class="stat-card"><div class="text-2xl mb-1">✅</div><div class="stat-number">{{ $stats['total_completions'] }}</div><div class="stat-label">Penyelesaian</div></div>
        <div class="stat-card"><div class="text-2xl mb-1">🏆</div><div class="stat-number text-terra-cotta">{{ $stats['certificates'] }}</div><div class="stat-label">Sertifikat</div></div>
        <div class="stat-card"><div class="text-2xl mb-1">💬</div><div class="stat-number">{{ $stats['forum_posts'] }}</div><div class="stat-label">Post Forum</div></div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Score Impact Chart --}}
        <div class="lg:col-span-2 card p-6">
            <h2 class="font-bold text-rich-black mb-4">📈 Dampak Edukasi: Rata-rata Pre-test vs Post-test</h2>
            @if($scoreData && $scoreData->avg_pre)
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="p-4 bg-melon-tint rounded-xl text-center">
                    <p class="text-sm text-cool-gray">Rata-rata Pre-test</p>
                    <p class="text-3xl font-bold text-terra-cotta">{{ round($scoreData->avg_pre) }}</p>
                </div>
                <div class="p-4 bg-mint-green-glow rounded-xl text-center">
                    <p class="text-sm text-cool-gray">Rata-rata Post-test</p>
                    <p class="text-3xl font-bold text-deep-fern-green">{{ round($scoreData->avg_post) }}</p>
                </div>
            </div>
            @php $improvement = $scoreData->avg_post - $scoreData->avg_pre; @endphp
            <div class="alert-success">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Rata-rata peningkatan literasi: <strong>+{{ round($improvement) }} poin</strong> per pengguna
            </div>
            @else
            <div class="text-center py-8 text-cool-gray">
                <div class="text-4xl mb-2">📊</div>
                <p>Data pre/post test belum tersedia</p>
            </div>
            @endif
        </div>

        {{-- Quick Links --}}
        <div class="card p-6">
            <h2 class="font-bold text-rich-black mb-4">⚡ Manajemen Cepat</h2>
            <div class="space-y-2">
                <a href="{{ route('admin.users.index') }}" class="sidebar-link w-full">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Kelola User
                </a>
                <a href="{{ route('admin.modules.index') }}" class="sidebar-link w-full">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    Kelola Modul
                </a>
                <a href="{{ route('admin.courses.index') }}" class="sidebar-link w-full">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    Kelola Kursus
                </a>
                <a href="{{ route('admin.reports') }}" class="sidebar-link w-full">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Laporan Dampak
                </a>
                <a href="{{ route('forum.index') }}" class="sidebar-link w-full">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    Moderasi Forum
                </a>
            </div>
        </div>
    </div>

    {{-- Recent Users --}}
    <div class="card mt-6">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-bold text-rich-black">👥 User Terbaru</h2>
            <a href="{{ route('admin.users.index') }}" class="text-sm text-deep-fern-green font-medium hover:underline">Lihat Semua</a>
        </div>
        <table class="table-cf">
            <thead><tr><th>Nama</th><th>Email</th><th>Role</th><th>Bergabung</th><th>Aksi</th></tr></thead>
            <tbody>
                @foreach($recentUsers as $user)
                <tr>
                    <td class="font-medium text-rich-black">{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td><span class="{{ $user->role === 'admin' ? 'badge-peach' : 'badge-gray' }}">{{ ucfirst($user->role ?? 'user') }}</span></td>
                    <td>{{ $user->created_at->format('d M Y') }}</td>
                    <td><a href="{{ route('admin.users.show', $user) }}" class="text-deep-fern-green text-sm hover:underline">Detail</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
