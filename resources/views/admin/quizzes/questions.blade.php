@extends('layout')
@section('title', 'Kelola Pertanyaan')
@section('content')
<div class="container-cf py-10">
    <div class="mb-6">
        <a href="{{ route('admin.modules.index') }}" class="btn-ghost text-sm mb-2 inline-block">← Kembali ke Kelola Modul</a>
        <h1 class="text-2xl font-bold">📝 Pertanyaan untuk: {{ $quiz->title }}</h1>
        <p class="text-sm text-cool-gray">Total Pertanyaan: {{ $quiz->questions->count() }}</p>
    </div>

    @if(session('success'))
    <div class="alert-success mb-6">{{ session('success') }}</div>
    @endif
    
    @if ($errors->any())
        <div class="alert-error mb-6">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Add Form -->
        <div class="lg:col-span-1">
            <h2 class="text-lg font-bold mb-4">Tambah Pertanyaan</h2>
            <form action="{{ route('admin.quizzes.questions.store', $quiz) }}" method="POST" class="card p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-bold mb-1">Pertanyaan</label>
                    <textarea name="question_text" class="w-full border rounded-lg p-2" rows="3" required></textarea>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-1">Pilihan A</label>
                    <input type="text" name="option_0" class="w-full border rounded-lg p-2" required>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-1">Pilihan B</label>
                    <input type="text" name="option_1" class="w-full border rounded-lg p-2" required>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-1">Pilihan C</label>
                    <input type="text" name="option_2" class="w-full border rounded-lg p-2" required>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-1">Pilihan D</label>
                    <input type="text" name="option_3" class="w-full border rounded-lg p-2" required>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-1">Jawaban Benar</label>
                    <select name="correct_option" class="w-full border rounded-lg p-2" required>
                        <option value="0">A</option>
                        <option value="1">B</option>
                        <option value="2">C</option>
                        <option value="3">D</option>
                    </select>
                </div>
                <button type="submit" class="btn-primary w-full mt-2">Tambah Pertanyaan</button>
            </form>
        </div>

        <!-- List Questions -->
        <div class="lg:col-span-2 space-y-4">
            <h2 class="text-lg font-bold mb-4">Daftar Pertanyaan</h2>
            @forelse($quiz->questions as $index => $question)
                <div class="card p-4">
                    <p class="font-bold text-rich-black mb-2">{{ $index + 1 }}. {{ $question->question }}</p>
                    <div class="grid grid-cols-2 gap-2 text-sm mb-3">
                        <div class="p-2 rounded border {{ $question->correct_answer == 0 ? 'bg-green-100 border-green-500 font-bold' : '' }}">A. {{ $question->options[0] ?? '' }}</div>
                        <div class="p-2 rounded border {{ $question->correct_answer == 1 ? 'bg-green-100 border-green-500 font-bold' : '' }}">B. {{ $question->options[1] ?? '' }}</div>
                        <div class="p-2 rounded border {{ $question->correct_answer == 2 ? 'bg-green-100 border-green-500 font-bold' : '' }}">C. {{ $question->options[2] ?? '' }}</div>
                        <div class="p-2 rounded border {{ $question->correct_answer == 3 ? 'bg-green-100 border-green-500 font-bold' : '' }}">D. {{ $question->options[3] ?? '' }}</div>
                    </div>
                    <form method="POST" action="{{ route('admin.quizzes.questions.destroy', [$quiz, $question]) }}" onsubmit="return confirm('Hapus pertanyaan ini?')" class="text-right">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-xs text-red-500 hover:underline">Hapus Pertanyaan</button>
                    </form>
                </div>
            @empty
                <div class="card p-8 text-center text-cool-gray">
                    <p>Belum ada pertanyaan di kuis ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
