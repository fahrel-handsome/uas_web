@extends('layout')
@section('title', $category->name . ' — Forum CerdasFin')

@push('head')
<style>
body { overflow: hidden; }
main { min-height: unset !important; overflow: hidden; }
footer { display: none !important; }

/* ── WhatsApp-style chat ─────────────────────────────── */
.chat-bg {
  background-color: #e5ddd5;
  background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23cccccc' fill-opacity='0.15'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
.chat-header { background: #0b7443; color: white; }
.chat-bubble-left {
  background: white;
  border-radius: 0 16px 16px 16px;
  box-shadow: 0 1px 2px rgba(0,0,0,0.15);
  max-width: 75%;
}
.chat-bubble-right {
  background: #dcf8c6;
  border-radius: 16px 0 16px 16px;
  box-shadow: 0 1px 2px rgba(0,0,0,0.15);
  max-width: 75%;
}
.chat-input-bar { background: #f0f0f0; border-top: 1px solid #ddd; }
.chat-scroll {
  height: calc(100vh - 180px);
  min-height: 300px;
  overflow-y: auto;
  scroll-behavior: smooth;
}
.msg-time { font-size: 10px; color: #999; white-space: nowrap; margin-top: 2px; }
.date-divider { text-align: center; margin: 12px 0; }
.date-divider span {
  background: rgba(255,255,255,0.85);
  padding: 4px 14px;
  border-radius: 9999px;
  font-size: 11px;
  color: #5b616b;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}
.reply-panel {
  border-top: 1px solid #e5e7eb;
  padding: 8px 12px;
  background: #f8fdf9;
  display: none;
}
.reply-panel.active { display: block; }
</style>
@endpush

@section('content')
<div class="flex flex-col" style="height: calc(100vh - 64px);">

    {{-- Chat Header (WA-style) --}}
    <div class="chat-header px-4 py-3 flex items-center gap-3 sticky top-16 z-30">
        <a href="{{ route('forum.index') }}" class="text-white/80 hover:text-white mr-1">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        {{-- Group Avatar --}}
        <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-xl flex-shrink-0">💬</div>
        <div class="flex-1 min-w-0">
            <p class="font-bold text-white leading-tight">{{ $category->name }}</p>
            <p class="text-xs text-green-200 truncate">{{ $messages->count() }} pesan · {{ $category->description }}</p>
        </div>
        @auth
        <div class="text-xs text-green-200 hidden sm:block">
            ⭐ {{ auth()->user()->userPoints->total_points ?? 0 }} poin
        </div>
        @endauth
    </div>

    {{-- Flash Success --}}
    @if(session('success'))
    <div class="mx-4 mt-2">
        <div class="alert-success text-sm">✅ {{ session('success') }}</div>
    </div>
    @endif

    {{-- Chat Body --}}
    <div class="chat-bg chat-scroll flex-1 px-4 py-4" id="chatBody">

        {{-- Date Divider (start) --}}
        <div class="date-divider mb-4">
            <span>📌 {{ $category->name }}</span>
        </div>
        <div class="date-divider mb-6">
            <span>{{ $messages->first()?->created_at?->format('d M Y') ?? now()->format('d M Y') }}</span>
        </div>

        {{-- Messages --}}
        @forelse($messages as $msg)
            @php
                $isOwn = auth()->check() && auth()->id() === $msg->user_id;
                $prevMsg = $loop->first ? null : $messages[$loop->index - 1];
                $showDate = $prevMsg && $prevMsg->created_at->format('Y-m-d') !== $msg->created_at->format('Y-m-d');
            @endphp

            {{-- Date divider between days --}}
            @if($showDate)
            <div class="date-divider my-4">
                <span>{{ $msg->created_at->format('d M Y') }}</span>
            </div>
            @endif

            {{-- Message Bubble --}}
            <div id="msg-{{ $msg->id }}" class="flex {{ $isOwn ? 'justify-end' : 'justify-start' }} mb-3 gap-2">

                {{-- Avatar (left messages only) --}}
                @if(!$isOwn)
                <div class="w-8 h-8 rounded-full bg-deep-fern-green flex items-center justify-center text-white text-xs font-bold flex-shrink-0 mt-1">
                    {{ strtoupper(substr($msg->user->name ?? '?', 0, 1)) }}
                </div>
                @endif

                <div class="{{ $isOwn ? 'chat-bubble-right' : 'chat-bubble-left' }} p-3">
                    {{-- Sender name (only for others) --}}
                    @if(!$isOwn)
                    <p class="text-xs font-bold mb-1" style="color: #0b7443;">{{ $msg->user->name ?? 'Pengguna' }}</p>
                    @endif

                    {{-- Message content --}}
                    <p class="text-sm text-rich-black leading-relaxed" style="white-space: pre-wrap;">{{ $msg->content }}</p>

                    {{-- Timestamp & checkmarks --}}
                    <div class="flex items-center justify-end gap-1 mt-1">
                        <span class="msg-time">{{ $msg->created_at->format('H:i') }}</span>
                        @if($isOwn)
                        <svg class="w-3 h-3 text-blue-500" fill="currentColor" viewBox="0 0 24 24"><path d="M18 7l-8 8-4-4-1.4 1.4L10 17.8l9.4-9.4L18 7z"/></svg>
                        @endif
                    </div>

                    {{-- Replies (comments) inside bubble --}}
                    @if($msg->comments->count() > 0)
                    <div class="mt-2 pt-2 border-t border-black/10 space-y-2">
                        @foreach($msg->comments->take(5) as $reply)
                        <div class="flex items-start gap-2">
                            <div class="w-5 h-5 rounded-full bg-gray-300 flex items-center justify-center text-[9px] font-bold flex-shrink-0">
                                {{ strtoupper(substr($reply->user->name ?? '?', 0, 1)) }}
                            </div>
                            <div class="flex-1">
                                <p class="text-[11px] font-bold" style="color:#0b7443;">{{ $reply->user->name ?? 'Pengguna' }}</p>
                                <p class="text-xs text-cool-gray">{{ $reply->content }}</p>
                                <p class="msg-time">{{ $reply->created_at->format('H:i') }}</p>
                            </div>
                        </div>
                        @endforeach
                        @if($msg->comments->count() > 5)
                        <p class="text-xs text-cool-gray text-center">+ {{ $msg->comments->count() - 5 }} balasan lainnya</p>
                        @endif
                    </div>
                    @endif

                    {{-- Reply button --}}
                    @auth
                    <div class="mt-2 text-right">
                        <button onclick="toggleReply({{ $msg->id }})"
                                class="text-[10px] text-cool-gray hover:text-deep-fern-green transition-colors">
                            ↩ Balas
                        </button>
                    </div>
                    @endauth
                </div>

                {{-- Avatar (right messages only) --}}
                @if($isOwn)
                <div class="w-8 h-8 rounded-full bg-deep-fern-green flex items-center justify-center text-white text-xs font-bold flex-shrink-0 mt-1">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                @endif
            </div>

            {{-- Inline Reply Form --}}
            @auth
            <div id="reply-{{ $msg->id }}" class="reply-panel mx-10 mb-4 rounded-xl">
                <form method="POST" action="{{ route('forum.comment', [$category, $msg]) }}" class="flex gap-2">
                    @csrf
                    <input type="text" name="content" placeholder="Balas pesan {{ $msg->user->name ?? '' }}..."
                           class="flex-1 text-sm px-3 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-deep-fern-green"
                           required minlength="2" maxlength="1000">
                    <button type="submit" class="btn-primary text-xs py-2 px-4">Kirim</button>
                </form>
            </div>
            @endauth

        @empty
            <div class="date-divider">
                <span>💬 Belum ada pesan. Jadilah yang pertama!</span>
            </div>
        @endforelse

        {{-- Bottom anchor for auto-scroll --}}
        <div id="chatBottom"></div>
    </div>

    {{-- Input Bar (WA-style) --}}
    <div class="chat-input-bar px-3 py-2 sticky bottom-0">
        @auth
        <form method="POST" action="{{ route('forum.store', $category) }}"
              class="flex items-end gap-2" id="chatForm">
            @csrf
            <div class="flex-1 bg-white rounded-2xl border border-gray-200 flex items-end px-3 py-2 gap-2"
                 style="min-height: 44px;">
                <textarea name="content" id="chatInput"
                          placeholder="Tulis pesan..."
                          class="flex-1 text-sm resize-none outline-none bg-transparent leading-relaxed"
                          rows="1" maxlength="2000" required
                          style="min-height: 20px; max-height: 120px;"
                          oninput="autoResize(this)"></textarea>
            </div>
            <button type="submit"
                    class="w-11 h-11 rounded-full flex items-center justify-center flex-shrink-0 transition-all"
                    style="background: #0b7443;" title="Kirim">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                </svg>
            </button>
        </form>
        @else
        <div class="text-center py-2">
            <p class="text-sm text-cool-gray">
                <a href="{{ route('login') }}" class="text-deep-fern-green font-semibold hover:underline">Masuk</a>
                atau
                <a href="{{ route('register') }}" class="text-deep-fern-green font-semibold hover:underline">Daftar</a>
                untuk mengirim pesan
            </p>
        </div>
        @endauth
    </div>
</div>
@endsection

@push('scripts')
<script>
// Auto-scroll to bottom on load
function scrollToBottom() {
    const chatBody = document.getElementById('chatBody');
    if (chatBody) {
        chatBody.scrollTop = chatBody.scrollHeight;
    }
}
scrollToBottom();

// Scroll to specific message if fragment in URL
const hash = window.location.hash;
if (hash) {
    const el = document.querySelector(hash);
    if (el) {
        setTimeout(() => el.scrollIntoView({ behavior: 'smooth', block: 'center' }), 300);
    }
}

// Auto-resize textarea
function autoResize(textarea) {
    textarea.style.height = 'auto';
    textarea.style.height = Math.min(textarea.scrollHeight, 120) + 'px';
}

// Submit on Enter (Shift+Enter for newline)
const chatInput = document.getElementById('chatInput');
if (chatInput) {
    chatInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            if (this.value.trim().length >= 2) {
                document.getElementById('chatForm').submit();
            }
        }
    });
}

// Toggle reply panel
function toggleReply(msgId) {
    const panel = document.getElementById('reply-' + msgId);
    if (!panel) return;
    const isActive = panel.classList.contains('active');
    // Close all others
    document.querySelectorAll('.reply-panel').forEach(p => p.classList.remove('active'));
    if (!isActive) {
        panel.classList.add('active');
        panel.querySelector('input')?.focus();
    }
}

// Auto-refresh every 30 seconds to get new messages
setInterval(() => {
    window.location.reload();
}, 30000);
</script>
@endpush
