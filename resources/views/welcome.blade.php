@extends('layout')

@section('title', 'CerdasFin — Platform Literasi Keuangan Indonesia')
@section('meta_description', 'Pelajari literasi keuangan, lindungi diri dari pinjol ilegal dan judi online. Platform edukasi finansial interaktif untuk masyarakat Indonesia.')

@section('content')

{{-- ===== HERO ===== --}}
<section class="hero-gradient py-24 overflow-hidden relative">
    <div class="container-cf relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="animate-fade-in-up">
                <div class="badge-green mb-6 inline-flex">🇮🇩 Untuk Masyarakat Indonesia</div>
                <h1 class="text-5xl lg:text-6xl font-bold text-rich-black leading-tight mb-6" style="letter-spacing:-0.02em;">
                    Cerdas Kelola<br>
                    <span class="text-deep-fern-green">Keuanganmu</span><br>
                    Mulai Hari Ini
                </h1>
                <p class="text-cool-gray text-lg mb-8 max-w-lg leading-relaxed">
                    Pelajari literasi keuangan, hindari jebakan pinjol ilegal dan judi online. Platform edukasi finansial berbasis data, terukur dan interaktif.
                </p>
                <div class="flex flex-wrap gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-primary text-base px-6 py-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            Lanjut Belajar
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn-primary text-base px-6 py-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                            Daftar Gratis
                        </a>
                        <a href="{{ route('login') }}" class="btn-secondary text-base px-6 py-3">Sudah punya akun? Masuk</a>
                    @endauth
                </div>
                <div class="flex items-center gap-6 mt-10 pt-8 border-t border-green-200">
                    <div><p class="text-2xl font-bold text-rich-black">2.263</p><p class="text-xs text-cool-gray">Pinjol diblokir OJK 2025</p></div>
                    <div class="w-px h-10 bg-gray-200"></div>
                    <div><p class="text-2xl font-bold text-rich-black">Rp 9T</p><p class="text-xs text-cool-gray">Kerugian judol per tahun</p></div>
                    <div class="w-px h-10 bg-gray-200"></div>
                    <div><p class="text-2xl font-bold text-deep-fern-green">Gratis</p><p class="text-xs text-cool-gray">Seluruh konten edukasi</p></div>
                </div>
            </div>

            {{-- Hero visual --}}
            <div class="hidden lg:block animate-fade-in-up delay-200">
                <div class="relative">
                    <div class="card-elevated p-8 rounded-3xl">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="avatar">F</div>
                            <div>
                                <p class="font-semibold text-rich-black text-sm">Fahrel</p>
                                <p class="text-xs text-deep-fern-green">Level Mahir • 350 poin</p>
                            </div>
                            <div class="ml-auto badge-green">🏆 Expert</div>
                        </div>
                        <div class="space-y-4">
                            <div class="p-4 bg-mint-green-glow rounded-2xl">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm font-medium text-rich-black">Dasar Literasi Keuangan</span>
                                    <span class="text-sm font-bold text-deep-fern-green">85%</span>
                                </div>
                                <div class="progress-bar"><div class="progress-fill" style="width:85%"></div></div>
                                <p class="text-xs text-cool-gray mt-1">Pre-test: 60 → Post-test: 85 ✅</p>
                            </div>
                            <div class="p-4 bg-melon-tint rounded-2xl">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm font-medium text-rich-black">Bahaya Pinjol Ilegal</span>
                                    <span class="text-sm font-bold text-terra-cotta">40%</span>
                                </div>
                                <div class="progress-bar"><div class="progress-fill-orange" style="width:40%;height:8px;border-radius:9999px;"></div></div>
                            </div>
                            <div class="flex gap-3">
                                <div class="flex-1 p-3 bg-subtle-ash rounded-xl text-center">
                                    <p class="text-xl font-bold text-rich-black">3</p>
                                    <p class="text-xs text-cool-gray">Sertifikat</p>
                                </div>
                                <div class="flex-1 p-3 bg-subtle-ash rounded-xl text-center">
                                    <p class="text-xl font-bold text-deep-fern-green">7🔥</p>
                                    <p class="text-xs text-cool-gray">Streak Hari</p>
                                </div>
                                <div class="flex-1 p-3 bg-subtle-ash rounded-xl text-center">
                                    <p class="text-xl font-bold text-rich-black">350</p>
                                    <p class="text-xs text-cool-gray">Total Poin</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Floating badge --}}
                    <div class="absolute -top-4 -right-4 bg-deep-fern-green text-white px-4 py-2 rounded-2xl text-sm font-bold shadow-lg">
                        ✅ Post-test +25 poin!
                    </div>
                    <div class="absolute -bottom-4 -left-4 bg-melon-tint text-terra-cotta px-4 py-2 rounded-2xl text-sm font-bold shadow-md border border-light-peach">
                        ⚠️ Hindari pinjol ilegal!
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== 4 MODUL UTAMA ===== --}}
<section class="section">
    <div class="container-cf">
        <div class="text-center mb-12">
            <div class="badge-gray mb-4">📚 Modul Pembelajaran</div>
            <h2 class="text-4xl font-bold text-rich-black mb-4">4 Modul Utama CerdasFin</h2>
            <p class="text-cool-gray text-lg max-w-2xl mx-auto">Kurikulum terstruktur dari dasar literasi hingga perlindungan aktif dari ancaman finansial</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @php
            $modulCards = [
                ['icon'=>'💰','title'=>'Dasar Literasi Keuangan','desc'=>'Pahami konsep dasar keuangan: menabung, anggaran 50/30/20, dan fondasi finansial yang kuat.','color'=>'mint','badge'=>'Fondasi','route'=>'modules.index'],
                ['icon'=>'🚫','title'=>'Bahaya Pinjol Ilegal','desc'=>'Kenali ciri-ciri pinjol ilegal, dampak bunga majemuk yang mencekik, dan cara melaporkannya ke OJK.','color'=>'peach','badge'=>'Waspada','route'=>'modules.index'],
                ['icon'=>'🎰','title'=>'Bahaya Judi Online','desc'=>'Pahami matematika kekalahan judi online, dampak psikologis, dan strategi keluar dari kecanduan.','color'=>'peach','badge'=>'Lindungi Diri','route'=>'modules.index'],
                ['icon'=>'📈','title'=>'Pengelolaan Keuangan Sehat','desc'=>'Investasi aman (emas, deposito), dana darurat, dan perencanaan finansial jangka panjang.','color'=>'mint','badge'=>'Sejahtera','route'=>'modules.index'],
            ];
            @endphp

            @foreach($modulCards as $i => $card)
            <div class="card-{{ $card['color'] }} p-8 rounded-2xl hover:scale-[1.01] transition-transform duration-200 animate-fade-in-up delay-{{ ($i+1)*100 }}">
                <div class="flex items-start justify-between mb-4">
                    <div class="text-4xl">{{ $card['icon'] }}</div>
                    <div class="badge-{{ $card['color']==='mint'?'green':'peach' }}">{{ $card['badge'] }}</div>
                </div>
                <h3 class="text-xl font-bold text-rich-black mb-2">{{ $card['title'] }}</h3>
                <p class="text-cool-gray text-sm mb-6 leading-relaxed">{{ $card['desc'] }}</p>
                <a href="{{ route($card['route']) }}" class="flex items-center gap-2 text-sm font-semibold text-deep-fern-green hover:gap-3 transition-all">
                    Mulai Belajar <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== KURSUS POPULER ===== --}}
@if($popularCourses->count() > 0)
<section class="section-alt">
    <div class="container-cf">
        <div class="flex items-center justify-between mb-10">
            <div>
                <div class="badge-green mb-3">🎓 Kursus</div>
                <h2 class="text-3xl font-bold text-rich-black">Kursus Populer</h2>
            </div>
            <a href="{{ route('courses.index') }}" class="btn-ghost text-sm">Lihat Semua →</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($popularCourses as $course)
            <div class="card overflow-hidden group hover:shadow-lg transition-shadow duration-300">
                <div class="h-40 bg-mint-green-glow flex items-center justify-center overflow-hidden">
                    <svg class="w-14 h-14 text-deep-fern-green opacity-30 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <div class="p-6">
                    <p class="text-xs text-deep-fern-green font-semibold mb-1">{{ $course->module->title }}</p>
                    <h3 class="font-bold text-rich-black mb-2 line-clamp-2">{{ $course->title }}</h3>
                    <p class="text-sm text-cool-gray mb-4 line-clamp-2">{{ $course->description }}</p>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-cool-gray">📚 {{ $course->lessons()->count() }} pelajaran</span>
                        <a href="{{ route('courses.show', $course) }}" class="text-sm font-semibold text-deep-fern-green hover:underline">Mulai →</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ===== FITUR UNGGULAN ===== --}}
<section class="section">
    <div class="container-cf">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-rich-black mb-4">Kenapa CerdasFin?</h2>
            <p class="text-cool-gray text-lg max-w-xl mx-auto">Platform yang dirancang khusus untuk dampak nyata literasi keuangan</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php $features = [
                ['icon'=>'📊','title'=>'Pre-test & Post-test','desc'=>'Ukur peningkatan pengetahuanmu secara akurat sebelum dan setelah belajar dengan grafik yang jelas.','color'=>'mint'],
                ['icon'=>'🎮','title'=>'Gamifikasi & Badge','desc'=>'Kumpulkan poin, raih badge, dan pertahankan streak belajar harian untuk motivasi yang konsisten.','color'=>'peach'],
                ['icon'=>'🔢','title'=>'Simulasi Keuangan','desc'=>'Coba simulasi bunga pinjol, tabungan, dan investasi aman secara interaktif dan real-time.','color'=>'mint'],
                ['icon'=>'🏆','title'=>'Sertifikat Digital','desc'=>'Dapatkan sertifikat otomatis setelah menyelesaikan modul sebagai bukti kompetensi finansial.','color'=>'peach'],
                ['icon'=>'💬','title'=>'Forum Komunitas','desc'=>'Diskusi, berbagi tips, dan belajar dari pengalaman sesama pengguna bersama mentor berpengalaman.','color'=>'mint'],
                ['icon'=>'🛡️','title'=>'Anti Pinjol & Judol','desc'=>'Edukasi interaktif untuk mengenali dan menghindari jebakan pinjol ilegal dan judi online.','color'=>'peach'],
            ]; @endphp
            @foreach($features as $i => $f)
            <div class="card p-6 animate-fade-in-up delay-{{ ($i % 3 + 1) * 100 }}">
                <div class="text-3xl mb-4">{{ $f['icon'] }}</div>
                <h3 class="font-bold text-rich-black mb-2">{{ $f['title'] }}</h3>
                <p class="text-sm text-cool-gray leading-relaxed">{{ $f['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== CTA ===== --}}
<section class="bg-deep-fern-green py-20">
    <div class="container-cf text-center">
        <h2 class="text-4xl font-bold text-white mb-4">Mulai Perjalanan Finansialmu</h2>
        <p class="text-muted-sage text-lg mb-8 max-w-xl mx-auto">Bergabunglah dan tingkatkan literasi keuanganmu. Gratis selamanya untuk semua masyarakat Indonesia.</p>
        @auth
            <a href="{{ route('courses.index') }}" class="inline-flex items-center gap-2 bg-white text-deep-fern-green px-8 py-4 rounded-xl font-bold text-lg hover:bg-muted-sage transition-colors">
                📚 Jelajahi Semua Kursus
            </a>
        @else
            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-white text-deep-fern-green px-8 py-4 rounded-xl font-bold text-lg hover:bg-muted-sage transition-colors">
                🚀 Daftar Gratis Sekarang
            </a>
        @endauth
    </div>
</section>

@endsection
