@extends('layout')

@section('title', $lesson->title . ' - CerdasFin')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-3">
                <div class="bg-canvas-white rounded-xl shadow-sm border border-gray-100 p-8 mb-8">
                    <div class="mb-6">
                        <a href="{{ route('courses.show', $course) }}" class="text-cool-gray hover:text-deep-fern-green font-medium flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Kembali ke {{ $course->title }}
                        </a>
                    </div>
                    
                    <h1 class="text-4xl font-bold text-rich-black mb-4">{{ $lesson->title }}</h1>
                    @if($lesson->duration_minutes)
                        <p class="text-cool-gray mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-leafy-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Durasi: {{ $lesson->duration_minutes }} menit
                        </p>
                    @endif

                    <!-- Video Section -->
                    @if($lesson->video_url)
                        @php
                            $videoUrl = $lesson->video_url;
                            // Extract video ID from any youtube url (watch, youtu.be, embed, nocookie)
                            if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/|youtube-nocookie\.com\/embed\/)([a-zA-Z0-9_-]+)/', $videoUrl, $matches)) {
                                $videoId = $matches[1];
                                $videoUrl = 'https://www.youtube-nocookie.com/embed/' . $videoId . '?rel=0';
                            }
                        @endphp
                        <div class="mb-8 rounded-xl overflow-hidden shadow-md">
                            <iframe width="100%" height="450" src="{{ $videoUrl }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    @endif

                    <!-- Content -->
                    <div class="prose prose-lg max-w-none mb-8 text-cool-gray">
                        {!! $lesson->content !!}
                    </div>

                    <!-- Complete Button -->
                    @auth
                        <form method="POST" action="{{ route('courses.lesson.complete', [$course, $lesson]) }}">
                            @csrf
                            <button type="submit" class="bg-deep-fern-green text-white px-8 py-3 rounded-xl hover:bg-opacity-90 transition font-medium w-full md:w-auto flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Tandai Sebagai Selesai
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="bg-deep-fern-green text-white px-8 py-3 rounded-xl hover:bg-opacity-90 transition font-medium inline-block">
                            Masuk untuk Melanjutkan
                        </a>
                    @endauth
                </div>

                <!-- Navigation -->
                @if($nextLesson)
                    <div class="text-center">
                        <a href="{{ route('courses.lesson', [$course, $nextLesson]) }}" class="bg-canvas-white text-deep-fern-green border border-deep-fern-green px-8 py-3 rounded-xl hover:bg-muted-sage transition font-medium inline-block flex items-center justify-center gap-2 max-w-md mx-auto">
                            Pelajaran Berikutnya: {{ $nextLesson->title }}
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                @endif
            </div>

            <!-- Sidebar - Course Outline -->
            <div class="lg:col-span-1">
                <div class="bg-canvas-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-24">
                    <h3 class="text-xl font-bold mb-4 text-rich-black">Outline Kursus</h3>
                    <div class="space-y-2 max-h-96 overflow-y-auto">
                        @foreach($course->lessons as $item)
                            <a href="{{ route('courses.lesson', [$course, $item]) }}" 
                               class="block p-3 rounded-xl transition {{ $item->id === $lesson->id ? 'bg-mint-green-glow border border-leafy-green' : 'hover:bg-subtle-ash' }}">
                                <p class="font-medium text-sm {{ $item->id === $lesson->id ? 'text-deep-fern-green' : 'text-cool-gray' }}">
                                    {{ $item->order }}. {{ Str::limit($item->title, 25) }}
                                </p>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
