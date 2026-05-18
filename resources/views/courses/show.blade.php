@extends('layout')

@section('title', $course->title . ' - CerdasFin')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <div class="bg-canvas-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                    @if($course->thumbnail)
                        <img src="{{ $course->thumbnail }}" alt="{{ $course->title }}" class="w-full h-80 object-cover">
                    @else
                        <div class="w-full h-80 bg-mint-green-glow flex items-center justify-center">
                            <svg class="w-20 h-20 text-deep-fern-green opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                    <div class="p-8">
                        <p class="text-deep-fern-green font-semibold mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            {{ $course->module->title }}
                        </p>
                        <h1 class="text-4xl font-bold text-rich-black mb-4">{{ $course->title }}</h1>
                        <p class="text-cool-gray text-lg mb-6">{{ $course->description }}</p>

                        @if($progress)
                            <div class="mb-6 bg-subtle-ash p-4 rounded-xl">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm font-semibold text-rich-black">Kemajuan Belajar</span>
                                    <span class="text-sm text-deep-fern-green font-bold">{{ $progress->progress_percentage }}%</span>
                                </div>
                                <div class="w-full bg-white rounded-full h-4">
                                    <div class="bg-deep-fern-green h-4 rounded-full transition-all duration-500" style="width: {{ $progress->progress_percentage }}%"></div>
                                </div>
                            </div>
                        @endif

                        @if($course->duration_minutes)
                            <p class="text-cool-gray mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-leafy-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Durasi: {{ $course->duration_minutes }} menit
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Lessons Section -->
                <div class="bg-canvas-white rounded-xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-2xl font-bold text-rich-black mb-6">Materi Pelajaran</h2>
                    @if($course->lessons->count() > 0)
                        <div class="space-y-4">
                            @foreach($course->lessons as $lesson)
                                <div class="border border-gray-100 rounded-xl p-4 hover:bg-mint-green-glow hover:border-leafy-green transition-all group">
                                    <a href="{{ route('courses.lesson', [$course, $lesson]) }}" class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-10 h-10 bg-subtle-ash group-hover:bg-deep-fern-green rounded-full flex items-center justify-center text-rich-black group-hover:text-white font-bold transition-colors">
                                                {{ $lesson->order }}
                                            </div>
                                            <div>
                                                <h3 class="font-semibold text-rich-black">{{ $lesson->title }}</h3>
                                                @if($lesson->duration_minutes)
                                                    <p class="text-sm text-cool-gray">⏱️ {{ $lesson->duration_minutes }} menit</p>
                                                @endif
                                            </div>
                                        </div>
                                        <svg class="w-6 h-6 text-cool-gray group-hover:text-deep-fern-green transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-cool-gray text-center py-8">Belum ada pelajaran dalam kursus ini.</p>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Quiz Section -->
                @if($course->quizzes->count() > 0)
                    <div class="bg-canvas-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                        <h3 class="text-xl font-bold text-rich-black mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-terra-cotta" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Kuis & Assessment
                        </h3>
                        <div class="space-y-3">
                            @foreach($course->quizzes as $quiz)
                                <a href="{{ route('quizzes.show', [$course, $quiz]) }}" class="block p-4 border border-gray-100 rounded-xl hover:bg-melon-tint transition-all group">
                                    <p class="font-semibold text-rich-black group-hover:text-terra-cotta">{{ $quiz->title }}</p>
                                    <p class="text-sm text-cool-gray">Nilai minimum: {{ $quiz->passing_score }}%</p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Course Info -->
                <div class="bg-deep-fern-green text-white rounded-xl shadow-md p-6 relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 bg-white opacity-5 w-40 h-40 rounded-full"></div>
                    <h3 class="text-xl font-bold mb-6 relative z-10">Informasi Kursus</h3>
                    <div class="space-y-6 text-sm relative z-10">
                        <div class="flex items-center justify-between">
                            <p class="text-muted-sage opacity-80">Total Pelajaran</p>
                            <p class="text-3xl font-bold">{{ $course->lessons()->count() }}</p>
                        </div>
                        <div class="w-full h-px bg-white opacity-20"></div>
                        <div class="flex items-center justify-between">
                            <p class="text-muted-sage opacity-80">Total Kuis</p>
                            <p class="text-3xl font-bold">{{ $course->quizzes()->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
