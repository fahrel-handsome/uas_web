@extends('layout')
@section('title', 'Post-Test: ' . $module->title . ' — CerdasFin')

@section('content')
<div class="container-cf py-12 max-w-3xl">
    <div class="text-center mb-8">
        <div class="badge-green mb-4 inline-flex">🎯 Post-Test Akhir</div>
        <h1 class="text-3xl font-bold text-rich-black mb-2">{{ $quiz->title }}</h1>
        <p class="text-cool-gray">Tunjukkan seberapa banyak yang telah kamu pelajari dari modul <strong>{{ $module->title }}</strong>.</p>
        <p class="text-sm text-cool-gray mt-1">Nilai minimal lulus: <strong class="text-deep-fern-green">{{ $quiz->passing_score ?? 70 }}%</strong></p>
    </div>

    <form method="POST" action="{{ route('modules.post-test.submit', $module) }}" x-data="quizForm({{ $quiz->questions->count() }})">
        @csrf
        <div class="space-y-6">
            @foreach($quiz->questions as $i => $question)
            <div class="card p-6 animate-fade-in-up" style="animation-delay: {{ $i * 0.1 }}s">
                <div class="flex items-start gap-3 mb-4">
                    <span class="w-8 h-8 bg-muted-sage text-deep-fern-green rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0">{{ $i+1 }}</span>
                    <p class="font-medium text-rich-black">{{ $question->question }}</p>
                </div>
                <div class="space-y-2 pl-11">
                    @foreach($question->options as $j => $option)
                    <label class="quiz-option" :class="selected[{{ $question->id }}] === {{ $j }} ? 'selected' : ''">
                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $j }}" @change="select({{ $question->id }}, {{ $j }})" class="sr-only" required>
                        <div class="w-5 h-5 rounded-full border-2 flex-shrink-0 flex items-center justify-center" :class="selected[{{ $question->id }}] === {{ $j }} ? 'border-deep-fern-green' : 'border-gray-300'">
                            <div x-show="selected[{{ $question->id }}] === {{ $j }}" class="w-2.5 h-2.5 rounded-full bg-deep-fern-green"></div>
                        </div>
                        <span class="text-sm text-rich-black">{{ $option }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-8 flex items-center justify-between">
            <a href="{{ route('modules.show', $module) }}" class="btn-ghost">← Kembali ke Modul</a>
            <button type="submit" :disabled="answered < total" class="btn-primary" :class="answered < total ? 'opacity-50 cursor-not-allowed' : ''">
                ✅ Kumpulkan Jawaban
            </button>
        </div>
        <p class="text-center text-sm text-cool-gray mt-3"><span x-text="answered"></span> / {{ $quiz->questions->count() }} soal dijawab</p>
    </form>
</div>
@endsection

@push('scripts')
<script>
function quizForm(total) {
    return { selected: {}, answered: 0, total,
        select(qid, val) { if (!this.selected[qid] && this.selected[qid] !== 0) this.answered++; this.selected[qid] = val; }
    }
}
</script>
@endpush
