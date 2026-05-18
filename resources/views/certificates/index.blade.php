@extends('layout')
@section('title', 'Sertifikat Saya — CerdasFin')

@section('content')
<div class="container-cf py-12">
    <div class="flex items-center justify-between mb-8">
        <div>
            <div class="badge-green mb-3">🏆 Prestasi</div>
            <h1 class="text-3xl font-bold text-rich-black">Sertifikat Saya</h1>
            <p class="text-cool-gray mt-1">{{ $certificates->total() }} sertifikat berhasil diraih</p>
        </div>
        <a href="{{ route('courses.index') }}" class="btn-primary text-sm">+ Raih Sertifikat Baru</a>
    </div>

    @forelse($certificates as $cert)
    <div class="card mb-4 overflow-hidden">
        <div class="flex flex-col md:flex-row items-stretch">
            {{-- Certificate Preview --}}
            <div class="md:w-64 bg-gradient-to-br from-deep-fern-green to-[#095f38] p-8 flex flex-col items-center justify-center text-white text-center flex-shrink-0">
                <div class="text-5xl mb-2">🏆</div>
                <p class="text-sm font-semibold text-muted-sage">SERTIFIKAT</p>
                <p class="text-xs text-white/70 mt-1">{{ $cert->certificate_number }}</p>
            </div>
            {{-- Certificate Info --}}
            <div class="p-6 flex-1">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-rich-black mb-1">{{ $cert->course->title ?? 'Kursus' }}</h2>
                        <p class="text-sm text-cool-gray mb-3">{{ $cert->course->module->title ?? '' }}</p>
                        <div class="flex flex-wrap gap-3 text-sm">
                            <span class="badge-green">✅ Selesai</span>
                            <span class="text-cool-gray">Diterbitkan: {{ $cert->issued_at?->format('d M Y') }}</span>
                            @if($cert->expires_at)
                                <span class="text-cool-gray">Berlaku hingga: {{ $cert->expires_at->format('d M Y') }}</span>
                            @endif
                        </div>
                        <p class="text-xs text-cool-gray mt-3 font-mono bg-subtle-ash px-2 py-1 rounded inline-block">{{ $cert->certificate_number }}</p>
                    </div>
                    <a href="{{ route('certificates.download', $cert) }}" class="btn-secondary text-sm flex-shrink-0 ml-4">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Unduh
                    </a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="card p-16 text-center">
        <div class="text-6xl mb-4">🏆</div>
        <h2 class="text-2xl font-bold text-rich-black mb-2">Belum Ada Sertifikat</h2>
        <p class="text-cool-gray mb-6">Selesaikan kursus dan kuis untuk mendapatkan sertifikat pertamamu!</p>
        <a href="{{ route('courses.index') }}" class="btn-primary">Mulai Belajar Sekarang</a>
    </div>
    @endforelse

    @if($certificates->hasPages())
    <div class="mt-6">{{ $certificates->links() }}</div>
    @endif
</div>
@endsection
