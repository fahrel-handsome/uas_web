@extends('layout')
@section('title', $post->title . ' — Forum CerdasFin')

@section('content')
<div class="container-cf py-12">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-cool-gray mb-6 flex-wrap">
        <a href="{{ route('forum.index') }}" class="hover:text-deep-fern-green">Forum</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('forum.category', $category) }}" class="hover:text-deep-fern-green">{{ $category->name }}</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-rich-black">{{ Str::limit($post->title, 40) }}</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Main Post --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Post Content --}}
            <div class="card p-8">
                <div class="flex items-start gap-2 mb-4 flex-wrap">
                    @if($post->is_pinned) <span class="badge-green text-xs">📌 Disematkan</span> @endif
                    @if($post->is_closed) <span class="badge-gray text-xs">🔒 Ditutup</span> @endif
                </div>
                <h1 class="text-2xl font-bold text-rich-black mb-6">{{ $post->title }}</h1>

                <div class="flex items-center gap-3 mb-6 pb-6 border-b border-gray-100">
                    <div class="avatar">{{ strtoupper(substr($post->user->name ?? 'U', 0, 1)) }}</div>
                    <div>
                        <p class="font-semibold text-rich-black text-sm">{{ $post->user->name ?? 'Anonim' }}</p>
                        <p class="text-xs text-cool-gray">{{ $post->created_at->format('d M Y, H:i') }} · {{ $post->views ?? 0 }} dilihat</p>
                    </div>
                </div>

                <div class="prose-cf">
                    {!! nl2br(e($post->content)) !!}
                </div>
            </div>

            {{-- Comments --}}
            <div class="card p-8">
                <h2 class="font-bold text-rich-black mb-6">💬 {{ $post->comments->count() }} Komentar</h2>

                @forelse($post->comments as $comment)
                <div class="flex gap-4 mb-6 last:mb-0">
                    <div class="avatar flex-shrink-0">{{ strtoupper(substr($comment->user->name ?? 'U', 0, 1)) }}</div>
                    <div class="flex-1">
                        <div class="bg-subtle-ash rounded-2xl rounded-tl-none p-4">
                            <div class="flex items-center justify-between mb-2">
                                <p class="font-semibold text-rich-black text-sm">{{ $comment->user->name ?? 'Anonim' }}</p>
                                <p class="text-xs text-cool-gray">{{ $comment->created_at->diffForHumans() }}</p>
                            </div>
                            <p class="text-sm text-cool-gray">{{ $comment->content }}</p>
                        </div>
                        <div class="flex items-center gap-3 mt-1 pl-2">
                            <form method="POST" action="{{ route('forum.comment.like', $comment) }}" class="inline">
                                @csrf
                                <button type="submit" class="text-xs text-cool-gray hover:text-deep-fern-green transition-colors">
                                    👍 {{ $comment->likes ?? 0 }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-cool-gray">
                    <div class="text-3xl mb-2">💬</div>
                    <p class="text-sm">Belum ada komentar. Jadilah yang pertama!</p>
                </div>
                @endforelse

                {{-- Add Comment --}}
                @if(!$post->is_closed)
                    @auth
                    <div class="border-t border-gray-100 mt-6 pt-6">
                        <h3 class="font-semibold text-rich-black mb-4">Tulis Komentar</h3>
                        <form method="POST" action="{{ route('forum.comment', [$category, $post]) }}">
                            @csrf
                            <textarea name="content" rows="3" class="form-input resize-none mb-3" placeholder="Tulis komentarmu di sini..." required minlength="5"></textarea>
                            <button type="submit" class="btn-primary text-sm">Kirim Komentar</button>
                        </form>
                    </div>
                    @else
                    <div class="border-t border-gray-100 mt-6 pt-6 text-center">
                        <a href="{{ route('login') }}" class="btn-secondary text-sm">Masuk untuk berkomentar</a>
                    </div>
                    @endauth
                @else
                <div class="alert-warning mt-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    Topik ini telah ditutup.
                </div>
                @endif
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            <div class="card p-6">
                <h3 class="font-bold text-rich-black mb-4">📂 Tentang Kategori</h3>
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-mint-green-glow rounded-xl flex items-center justify-center text-xl">💬</div>
                    <div>
                        <p class="font-semibold text-rich-black text-sm">{{ $category->name }}</p>
                        <p class="text-xs text-cool-gray">{{ $category->description }}</p>
                    </div>
                </div>
                <a href="{{ route('forum.category', $category) }}" class="btn-ghost w-full justify-center text-sm mt-2">Lihat Semua Topik</a>
            </div>

            <div class="card-mint p-6 rounded-2xl">
                <h3 class="font-bold text-rich-black mb-2">💡 Tips Diskusi</h3>
                <ul class="text-sm text-cool-gray space-y-2">
                    <li>✅ Berikan informasi yang akurat</li>
                    <li>✅ Hormati pendapat orang lain</li>
                    <li>❌ Jangan promosi pinjol/judol</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
