@extends('layout')
@section('title', $module->title . ' — CerdasFin')

@section('content')
<div class="container-cf py-12">
    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-cool-gray mb-8">
        <a href="{{ route('modules.index') }}" class="hover:text-deep-fern-green">Modul</a>
        <span>/</span>
        <span class="text-rich-black font-medium">{{ $module->title }}</span>
    </div>

    {{-- Header --}}
    <div class="card-mint p-10 rounded-3xl mb-10">
        <div class="text-6xl mb-4">{{ $module->icon ?? '📚' }}</div>
        <h1 class="text-4xl font-bold text-rich-black mb-3">{{ $module->title }}</h1>
        <p class="text-cool-gray text-lg max-w-2xl">{{ $module->description }}</p>
    </div>

    {{-- Courses Grid --}}
    <h2 class="text-2xl font-bold text-rich-black mb-6">Kursus dalam Modul Ini</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($module->courses as $course)
        @php $progress = $userProgress[$course->id] ?? null; @endphp
        <div class="card overflow-hidden group hover:shadow-md transition-shadow flex flex-col">
            <div class="h-36 bg-mint-green-glow flex items-center justify-center">
                <svg class="w-12 h-12 text-deep-fern-green opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
            <div class="p-6 flex flex-col flex-grow">
                <h3 class="font-bold text-rich-black mb-2">{{ $course->title }}</h3>
                <p class="text-sm text-cool-gray mb-4 flex-grow">{{ Str::limit($course->description, 80) }}</p>
                @if($progress)
                <div class="mb-4">
                    <div class="flex justify-between text-xs mb-1">
                        <span class="text-cool-gray">Progress</span>
                        <span class="font-bold text-deep-fern-green">{{ $progress->progress_percentage }}%</span>
                    </div>
                    <div class="progress-bar"><div class="progress-fill" style="width:{{ $progress->progress_percentage }}%"></div></div>
                </div>
                @endif
                <a href="{{ route('courses.show', $course) }}" class="btn-primary w-full justify-center text-sm">
                    {{ $progress ? 'Lanjutkan' : 'Mulai' }} Kursus
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-12 card">
            <p class="text-cool-gray">Belum ada kursus dalam modul ini.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
