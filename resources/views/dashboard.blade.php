@extends('layout')
@section('title', 'Dashboard — CerdasFin')

@section('content')
<div class="container-cf py-10">

    {{-- Welcome Bar --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-rich-black">Hai, {{ Str::limit(Auth::user()->name, 20) }}! 👋</h1>
            <p class="text-cool-gray mt-1">Terus semangat belajar literasi keuangan hari ini.</p>
        </div>
        @if($userPoints)
        <div class="flex items-center gap-4 flex-wrap">
            <span class="{{ $levelLabel === 'Expert' || $levelLabel === 'Master' ? 'level-expert' : ($levelLabel === 'Mahir' ? 'level-mahir' : ($levelLabel === 'Pelajar' ? 'level-pelajar' : 'level-pemula')) }}">
                ⭐ {{ $levelLabel }}
            </span>
            <div class="card px-4 py-2 flex items-center gap-2">
                <span class="text-2xl font-bold text-deep-fern-green">{{ number_format($totalPoints) }}</span>
                <span class="text-xs text-cool-gray">poin</span>
            </div>
            <a href="{{ route('courses.index') }}" class="btn-primary text-sm">+ Pelajaran Baru</a>
        </div>
        @endif
    </div>

    {{-- Stats Row --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="stat-card animate-fade-in-up">
            <div class="text-2xl mb-1">📚</div>
            <div class="stat-number">{{ $enrolledCourses->count() }}</div>
            <div class="stat-label">Kursus Diikuti</div>
        </div>
        <div class="stat-card animate-fade-in-up delay-100">
            <div class="text-2xl mb-1">✅</div>
            <div class="stat-number text-deep-fern-green">{{ $completedCourses }}</div>
            <div class="stat-label">Kursus Selesai</div>
        </div>
        <div class="stat-card animate-fade-in-up delay-200">
            <div class="text-2xl mb-1">🏆</div>
            <div class="stat-number" style="color:#715039;">{{ $certificates }}</div>
            <div class="stat-label">Sertifikat</div>
        </div>
        <div class="stat-card animate-fade-in-up delay-300">
            <div class="text-2xl mb-1">🔥</div>
            <div class="stat-number text-deep-fern-green">{{ number_format($totalPoints) }}</div>
            <div class="stat-label">Total Poin</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left: Progress & Chart --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Level Progress Bar --}}
            @if($userPoints && $levelProgress['next'])
            <div class="card p-6">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="font-bold text-rich-black">⬆️ Progress Level</h2>
                    <span class="text-sm text-cool-gray">{{ $levelProgress['needed'] }} poin lagi ke <strong>{{ $levelProgress['next']['label'] }}</strong></span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width:{{ $levelProgress['progress'] }}%"></div>
                </div>
                <div class="flex justify-between text-xs text-cool-gray mt-1">
                    <span>{{ $levelProgress['current']['label'] }} ({{ $totalPoints }} poin)</span>
                    <span>{{ $levelProgress['next']['label'] }} ({{ $levelProgress['next']['min'] }} poin)</span>
                </div>
            </div>
            @endif

            {{-- Pre/Post Test Chart --}}
            @if($chartData->count() > 0)
            <div class="card p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-bold text-rich-black">📊 Grafik Perkembangan Belajar</h2>
                    <span class="badge-green text-xs">Pre-test vs Post-test</span>
                </div>
                <div class="chart-container">
                    <canvas id="scoreChart"></canvas>
                </div>
            </div>
            @endif

            {{-- Kursus Berlanjut --}}
            <div class="card p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-bold text-rich-black">📖 Kursus Berlanjut</h2>
                    <a href="{{ route('courses.index') }}" class="text-sm text-deep-fern-green font-medium hover:underline">Jelajahi Semua</a>
                </div>

                @forelse($enrolledCourses->take(4) as $progress)
                <div class="flex items-center gap-4 p-4 rounded-xl hover:bg-mint-green-glow transition-colors mb-2 last:mb-0">
                    <div class="w-10 h-10 rounded-xl bg-muted-sage flex items-center justify-center flex-shrink-0 text-deep-fern-green font-bold">
                        {{ strtoupper(substr($progress->course->title ?? 'K', 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-rich-black text-sm truncate">{{ $progress->course->title ?? 'Kursus' }}</p>
                        <p class="text-xs text-cool-gray mb-1">{{ $progress->course->module->title ?? '' }}</p>
                        <div class="progress-bar"><div class="progress-fill" style="width:{{ $progress->progress_percentage ?? 0 }}%"></div></div>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <p class="text-sm font-bold text-deep-fern-green">{{ $progress->progress_percentage ?? 0 }}%</p>
                        @if($progress->is_completed)
                            <span class="badge-green text-xs">Selesai</span>
                        @else
                            <a href="{{ route('courses.show', $progress->course) }}" class="text-xs text-deep-fern-green hover:underline">Lanjutkan →</a>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <div class="text-4xl mb-2">📚</div>
                    <p class="text-cool-gray text-sm mb-4">Kamu belum mengikuti kursus apapun.</p>
                    <a href="{{ route('courses.index') }}" class="btn-primary text-sm">Mulai Belajar</a>
                </div>
                @endforelse
            </div>

            {{-- Aktivitas Quiz Terbaru --}}
            @if($recentActivity->count() > 0)
            <div class="card p-6">
                <h2 class="font-bold text-rich-black mb-4">🎯 Aktivitas Quiz Terbaru</h2>
                <div class="space-y-3">
                    @foreach($recentActivity as $result)
                    <div class="flex items-center justify-between p-3 rounded-xl bg-subtle-ash">
                        <div>
                            <p class="text-sm font-medium text-rich-black">{{ $result->quiz->title ?? 'Quiz' }}</p>
                            <p class="text-xs text-cool-gray">
                                {{ $result->quiz->course->module->title ?? '' }}
                                · {{ $result->completed_at?->diffForHumans() ?? '' }}
                            </p>
                        </div>
                        <div class="text-right">
                            @php $sc = $result->score ?? 0; @endphp
                            <p class="text-lg font-bold {{ $sc >= 70 ? 'text-deep-fern-green' : 'text-red-500' }}">{{ $sc }}%</p>
                            <p class="text-xs {{ $sc >= 70 ? 'text-deep-fern-green' : 'text-red-500' }}">{{ $sc >= 70 ? '✅ Lulus' : '❌ Ulangi' }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>

        {{-- Right Sidebar --}}
        <div class="space-y-6">

            {{-- User Level Card --}}
            <div class="card-peach p-6 rounded-2xl">
                <div class="flex items-center gap-3 mb-4">
                    <div class="avatar w-12 h-12 text-base">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                    <div>
                        <p class="font-bold text-rich-black">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-cool-gray">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                @if($userPoints)
                <div class="mb-3">
                    <div class="flex justify-between text-xs mb-1">
                        <span class="text-cool-gray">Progress ke level berikutnya</span>
                        <span class="font-bold" style="color:#715039;">{{ $totalPoints }} / {{ $levelProgress['next']['min'] ?? '∞' }}</span>
                    </div>
                    <div class="progress-bar"><div class="progress-fill-orange" style="width:{{ $levelProgress['progress'] ?? 0 }}%;height:8px;border-radius:9999px;"></div></div>
                </div>
                <div class="grid grid-cols-2 gap-2 text-center">
                    <div class="bg-white/60 rounded-xl py-2">
                        <p class="font-bold text-rich-black text-sm">{{ $userPoints->badge ?? 'Pemula' }}</p>
                        <p class="text-xs text-cool-gray">Badge</p>
                    </div>
                    <div class="bg-white/60 rounded-xl py-2">
                        <p class="font-bold text-deep-fern-green">{{ $totalPoints }}</p>
                        <p class="text-xs text-cool-gray">Poin</p>
                    </div>
                </div>
                @endif
            </div>

            {{-- Quick Actions --}}
            <div class="card p-6">
                <h3 class="font-bold text-rich-black mb-4">⚡ Aksi Cepat</h3>
                <div class="space-y-2">
                    <a href="{{ route('courses.index') }}" class="sidebar-link w-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        Jelajahi Kursus
                    </a>
                    <a href="{{ route('modules.index') }}" class="sidebar-link w-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        Modul Pembelajaran
                    </a>
                    <a href="{{ route('simulation.index') }}" class="sidebar-link w-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        Simulasi Keuangan
                    </a>
                    <a href="{{ route('leaderboard.index') }}" class="sidebar-link w-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        Leaderboard
                    </a>
                    <a href="{{ route('certificates.index') }}" class="sidebar-link w-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                        Sertifikat Saya
                    </a>
                    <a href="{{ route('awareness.index') }}" class="sidebar-link w-full" style="color:#715039;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        Anti Pinjol &amp; Judol
                    </a>
                </div>
            </div>

            {{-- Reminder Card --}}
            <div class="card-mint p-6 rounded-2xl">
                <h3 class="font-bold text-rich-black mb-3">💡 Tip Finansial Hari Ini</h3>
                @php $tips = [
                    'Sisihkan minimal 20% penghasilan untuk tabungan sebelum belanja.',
                    'Jangan pernah meminjam dari pinjol yang tidak terdaftar di OJK.',
                    'Bangun dana darurat minimal 3-6x pengeluaran bulanan.',
                    'Investasi aman: reksa dana, emas, atau deposito bank resmi.',
                    'Hindari judi online — kemungkinan kalah selalu lebih besar dari menang.',
                    'Buat anggaran bulanan dengan metode 50/30/20.',
                ]; $tip = $tips[date('d') % count($tips)]; @endphp
                <p class="text-sm text-cool-gray leading-relaxed">{{ $tip }}</p>
                <a href="{{ route('awareness.index') }}" class="text-sm font-semibold text-deep-fern-green mt-3 block hover:underline">Pelajari lebih lanjut →</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@if($chartData->count() > 0)
<script>
const ctx = document.getElementById('scoreChart');
if (ctx) {
    const chartData = @json($chartData);
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartData.map(d => d.module),
            datasets: [
                {
                    label: 'Pre-test',
                    data: chartData.map(d => d.pre_test),
                    backgroundColor: 'rgba(97, 188, 118, 0.6)',
                    borderColor: '#61bc76',
                    borderWidth: 2,
                    borderRadius: 6,
                },
                {
                    label: 'Post-test',
                    data: chartData.map(d => d.post_test),
                    backgroundColor: 'rgba(11, 116, 67, 0.8)',
                    borderColor: '#0b7443',
                    borderWidth: 2,
                    borderRadius: 6,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top', labels: { font: { size: 12 } } },
                tooltip: { callbacks: { label: ctx => ctx.dataset.label + ': ' + ctx.raw + '%' } }
            },
            scales: {
                y: { beginAtZero: true, max: 100, grid: { color: '#f0f0f0' }, ticks: { callback: v => v + '%' } },
                x: { grid: { display: false } }
            }
        }
    });
}
</script>
@endif
@endpush
