@extends('layout')
@section('title', 'Kelola Soal Modul')
@section('content')
<div class="container-cf py-10">
    <div class="flex items-center justify-between mb-8">
        <div>
            <a href="{{ route('admin.modules.index') }}" class="btn-ghost text-sm mb-2 inline-block">← Kembali ke Modul</a>
            <h1 class="text-2xl font-bold">📝 Kelola Soal: {{ $module->title }}</h1>
        </div>
    </div>

    <div class="card overflow-hidden">
        <table class="table-cf">
            <thead>
                <tr>
                    <th>Kursus</th>
                    <th>Tipe Quiz</th>
                    <th>Judul Quiz</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($module->courses as $course)
                    @foreach($course->quizzes as $quiz)
                    <tr>
                        <td class="text-sm font-semibold">{{ $course->title }}</td>
                        <td>
                            @if($quiz->type == 'pre_test') <span class="badge-peach">Pre-Test</span>
                            @elseif($quiz->type == 'post_test') <span class="badge-green">Post-Test</span>
                            @else <span class="badge-gray">Quiz Regular</span> @endif
                        </td>
                        <td class="font-bold">{{ $quiz->title }}</td>
                        <td>
                            <a href="{{ route('admin.quizzes.questions', $quiz) }}" class="btn-primary text-xs py-1 px-3">Kelola Pertanyaan</a>
                        </td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
