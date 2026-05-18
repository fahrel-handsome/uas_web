@extends('layout')

@section('title', $quiz->title . ' - CerdasFin')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="mb-8">
                <a href="{{ route('courses.show', $course) }}" class="text-blue-600 hover:text-blue-800">← Kembali ke {{ $course->title }}</a>
            </div>

            <h1 class="text-4xl font-bold mb-4">{{ $quiz->title }}</h1>
            @if($quiz->description)
                <p class="text-gray-600 mb-6">{{ $quiz->description }}</p>
            @endif

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
                <p class="text-blue-900"><strong>Nilai Minimum:</strong> {{ $quiz->passing_score }}%</p>
                <p class="text-blue-900"><strong>Total Soal:</strong> {{ $quiz->questions->count() }}</p>
            </div>

            @if(Auth::check())
                <form method="POST" action="{{ route('quizzes.submit', [$course, $quiz]) }}">
                    @csrf
                    <div class="space-y-8">
                        @foreach($quiz->questions as $index => $question)
                            <div class="border rounded-lg p-6">
                                <h3 class="text-lg font-bold mb-4">Soal {{ $index + 1 }} dari {{ $quiz->questions->count() }}</h3>
                                <p class="text-gray-900 text-lg mb-6">{{ $question->question }}</p>

                                <div class="space-y-3">
                                    @foreach($question->options as $optionIndex => $option)
                                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-blue-50 transition">
                                            <input type="radio" name="answers[{{ $question->id }}]" value="{{ $optionIndex }}" class="w-4 h-4 text-blue-600">
                                            <span class="ml-3 text-gray-900">{{ $option }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-8 flex gap-4">
                        <a href="{{ route('courses.show', $course) }}" class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition font-semibold">Batal</a>
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">Serahkan Jawaban</button>
                    </div>
                </form>
            @else
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
                    <p class="text-yellow-900 mb-4">Anda harus masuk untuk mengikuti kuis.</p>
                    <a href="{{ route('login') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition inline-block">Masuk Sekarang</a>
                </div>
            @endif
        </div>
    </div>
@endsection
