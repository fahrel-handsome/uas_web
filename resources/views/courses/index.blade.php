@extends('layout')

@section('title', 'Kursus - CerdasFin')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-4xl font-bold text-rich-black mb-8">Semua Kursus</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div>
                <label class="block text-sm font-medium text-cool-gray mb-2">Cari Kursus</label>
                <input type="text" placeholder="Cari kursus..." class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-deep-fern-green focus:border-deep-fern-green">
            </div>
        </div>

        @if($courses->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($courses as $course)
                    <div class="bg-canvas-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow group flex flex-col">
                        @if($course->thumbnail)
                            <img src="{{ $course->thumbnail }}" alt="{{ $course->title }}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-48 bg-mint-green-glow flex items-center justify-center overflow-hidden">
                                <svg class="w-16 h-16 text-deep-fern-green opacity-40 group-hover:scale-110 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                        @endif
                        <div class="p-6 flex flex-col flex-grow">
                            <p class="text-sm text-deep-fern-green font-semibold mb-2 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                {{ $course->module->title }}
                            </p>
                            <h3 class="text-xl font-bold text-rich-black mb-2 line-clamp-2">{{ $course->title }}</h3>
                            <p class="text-cool-gray text-sm mb-6 flex-grow">{{ Str::limit($course->description, 80) }}</p>
                            
                            <div class="flex items-center justify-between mb-6 text-sm text-cool-gray">
                                @if($course->duration_minutes)
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-leafy-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $course->duration_minutes }} mnt
                                    </span>
                                @endif
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-leafy-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    {{ $course->lessons()->count() }} Pelajaran
                                </span>
                            </div>

                            <a href="{{ route('courses.show', $course) }}" class="w-full bg-deep-fern-green text-white py-3 rounded-xl text-center hover:bg-opacity-90 transition font-medium flex items-center justify-center gap-2">
                                Lihat Kursus
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $courses->links() }}
            </div>
        @else
            <div class="text-center py-12 bg-subtle-ash rounded-xl border border-gray-100">
                <svg class="w-16 h-16 text-cool-gray mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <p class="text-cool-gray text-lg">Tidak ada kursus yang tersedia saat ini.</p>
            </div>
        @endif
    </div>
@endsection
