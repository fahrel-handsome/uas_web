@extends('layout')
@section('title', 'Modul Belajar — CerdasFin')

@section('content')
<div class="container-cf py-12">
    <div class="mb-10">
        <div class="badge-green mb-3">📚 Kurikulum</div>
        <h1 class="text-4xl font-bold text-rich-black mb-2">Modul Pembelajaran</h1>
        <p class="text-cool-gray text-lg">4 modul utama dirancang khusus untuk meningkatkan literasi keuangan masyarakat Indonesia</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @forelse($modules as $module)
        <div class="card overflow-hidden group hover:shadow-lg transition-shadow">
            <div class="h-32 bg-mint-green-glow flex items-center justify-between px-8">
                <div class="text-6xl">{{ $module->icon ?? '📚' }}</div>
                <div class="badge-green">{{ $module->courses_count }} Kursus</div>
            </div>
            <div class="p-8">
                <h2 class="text-2xl font-bold text-rich-black mb-2">{{ $module->title }}</h2>
                <p class="text-cool-gray mb-6 leading-relaxed">{{ $module->description }}</p>
                <a href="{{ route('modules.show', $module) }}" class="btn-primary w-full justify-center">
                    Lihat Modul
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-2 text-center py-16 card">
            <div class="text-5xl mb-4">📚</div>
            <p class="text-cool-gray">Belum ada modul yang tersedia.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
