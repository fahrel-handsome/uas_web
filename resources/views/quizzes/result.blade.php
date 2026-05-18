@extends('layout')

@section('title', 'Hasil Kuis - CerdasFin')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-lg shadow-lg p-8 mb-8 text-center">
            @if($answer->passed)
                <div class="mb-4">
                    <span class="text-6xl">🎉</span>
                </div>
                <h1 class="text-3xl font-bold text-green-600 mb-4">Selamat Anda telah menyelesaikan kursus ini, silahkan download sertifikat Anda ke halaman sertifikat</h1>
            @else
                <div class="mb-4">
                    <span class="text-6xl">📚</span>
                </div>
                <h1 class="text-4xl font-bold text-red-600 mb-4">Coba Lagi</h1>
                <p class="text-gray-600 mb-4">Nilai Anda di bawah 90%. Silahkan mengulang kembali!</p>
            @endif

            <div class="bg-gradient-to-r from-blue-100 to-blue-50 rounded-lg p-8 mb-8">
                <p class="text-gray-600 text-lg mb-2">Nilai Anda</p>
                <p class="text-6xl font-bold text-blue-600">{{ $answer->score }}%</p>
                <p class="text-gray-600 mt-2">Nilai Minimum: 90%</p>
            </div>

            <div class="space-y-4 mb-8">
                <a href="{{ route('courses.show', $course) }}" class="block p-3 border rounded-lg hover:bg-gray-50 transition">
                    ← Kembali ke {{ $course->title }}
                </a>
                @if(!$answer->passed)
                    <form method="POST" action="{{ route('quizzes.submit', [$course, $quiz]) }}" class="inline-block w-full">
                        @csrf
                        <button type="submit" class="w-full p-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">Coba Lagi</button>
                    </form>
                @else
                    <a href="{{ route('certificates.index') }}" class="block p-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold">Lihat Sertifikat 🎓</a>
                @endif
            </div>
        </div>

        <!-- Answer Review -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold mb-6">Review Jawaban</h2>
            <div class="space-y-8">
                @foreach($quiz->questions as $index => $question)
                    @php
                        $userAnswer = $answer->answers[$question->id] ?? null;
                        $isCorrect = (int)$userAnswer === $question->correct_answer;
                    @endphp
                    <div class="border rounded-lg p-6">
                        <div class="flex items-start justify-between mb-4">
                            <h3 class="text-lg font-bold">Soal {{ $index + 1 }}</h3>
                            @if($isCorrect)
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">✓ Benar</span>
                            @else
                                <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold">✗ Salah</span>
                            @endif
                        </div>

                        <p class="text-gray-900 font-semibold mb-4">{{ $question->question }}</p>

                        <div class="space-y-2">
                            @foreach($question->options as $optionIndex => $option)
                                @php
                                    $isSelected = (int)$userAnswer === $optionIndex;
                                    $isCorrectOption = $optionIndex === $question->correct_answer;
                                @endphp
                                <div class="p-3 rounded-lg border @if($isCorrectOption) border-green-500 bg-green-50 @elseif($isSelected && !$isCorrectOption) border-red-500 bg-red-50 @else border-gray-200 @endif">
                                    <p class="text-gray-900">
                                        @if($isCorrectOption)
                                            <span class="font-semibold text-green-700">✓ {{ $option }}</span>
                                        @elseif($isSelected && !$isCorrectOption)
                                            <span class="font-semibold text-red-700">✗ {{ $option }}</span>
                                        @else
                                            <span class="text-gray-700">{{ $option }}</span>
                                        @endif
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
