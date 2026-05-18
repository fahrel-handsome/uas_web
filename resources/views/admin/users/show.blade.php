@extends('layout')
@section('title', $user->name . ' — Admin CerdasFin')

@section('content')
<div class="container-cf py-10">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.users.index') }}" class="btn-ghost text-sm">← Semua User</a>
        <h1 class="text-2xl font-bold text-rich-black">Detail User</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="card p-6">
            <div class="text-center">
                <div class="avatar w-16 h-16 text-2xl mx-auto mb-3">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                <h2 class="font-bold text-rich-black text-xl">{{ $user->name }}</h2>
                <p class="text-sm text-cool-gray">{{ $user->email }}</p>
                <div class="mt-3 mb-4">
                    <span class="{{ $user->role === 'admin' ? 'badge-peach' : 'badge-gray' }}">{{ ucfirst($user->role ?? 'user') }}</span>
                </div>
                <div class="text-sm text-cool-gray">Bergabung {{ $user->created_at->format('d M Y') }}</div>
            </div>
            <div class="border-t border-gray-100 mt-4 pt-4 grid grid-cols-3 gap-2 text-center">
                <div><p class="font-bold text-deep-fern-green">{{ $user->userPoints?->total_points ?? 0 }}</p><p class="text-xs text-cool-gray">Poin</p></div>
                <div><p class="font-bold text-rich-black">{{ $user->progressData->count() }}</p><p class="text-xs text-cool-gray">Kursus</p></div>
                <div><p class="font-bold text-terra-cotta">{{ $user->certificates->count() }}</p><p class="text-xs text-cool-gray">Sertifikat</p></div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="card p-6">
                <h3 class="font-bold text-rich-black mb-4">📚 Progress Kursus</h3>
                @forelse($user->progressData as $progress)
                <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-mint-green-glow mb-2">
                    <div class="flex-1">
                        <p class="font-medium text-rich-black text-sm">{{ $progress->course->title ?? '-' }}</p>
                        <div class="progress-bar mt-1"><div class="progress-fill" style="width:{{ $progress->progress_percentage }}%"></div></div>
                    </div>
                    <span class="text-sm font-bold text-deep-fern-green">{{ $progress->progress_percentage }}%</span>
                    @if($progress->is_completed) <span class="badge-green text-xs">✅</span> @endif
                </div>
                @empty
                <p class="text-cool-gray text-sm">Belum mengikuti kursus apapun.</p>
                @endforelse
            </div>

            @if($user->certificates->count())
            <div class="card p-6">
                <h3 class="font-bold text-rich-black mb-4">🏆 Sertifikat</h3>
                @foreach($user->certificates as $cert)
                <div class="flex items-center justify-between p-3 bg-subtle-ash rounded-xl mb-2">
                    <div>
                        <p class="text-sm font-medium text-rich-black">{{ $cert->course->title ?? '-' }}</p>
                        <p class="text-xs text-cool-gray font-mono">{{ $cert->certificate_number }}</p>
                    </div>
                    <span class="text-xs text-cool-gray">{{ $cert->issued_at?->format('d M Y') }}</span>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
