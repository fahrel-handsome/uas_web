@extends('layout')
@section('title', 'CerdasFin — Platform Literasi Keuangan Indonesia')
@section('meta_description', 'Belajar literasi keuangan, hindari pinjol ilegal & judi online bersama CerdasFin. Platform edukasi finansial terpercaya untuk masyarakat Indonesia.')

@section('content')

{{-- ===== STORY SCROLL ANIMATION SECTIONS ===== --}}
<main id="cerdasfin-story" class="w-full overflow-x-hidden">

  {{-- SECTION 01 — Hero --}}
  <section data-flow-section aria-label="Hero CerdasFin"
    class="relative min-h-screen w-full overflow-hidden"
    style="background: linear-gradient(135deg, #f0fdf4 0%, #d1fadf 50%, #e1fdea 100%);">
    <div data-flow-inner class="flow-art-container relative flex min-h-screen w-full flex-col justify-between gap-6 px-[4vw] pt-[clamp(2rem,8vw,4vw)] pb-[4vw]" style="transform-origin: bottom left;">

      <div class="flex items-center justify-between">
        <span class="text-xs font-bold uppercase tracking-[0.2em] text-deep-fern-green">01 — Tentang CerdasFin</span>
        <div class="badge-green">🌱 Platform Terpercaya</div>
      </div>

      <hr class="border-none border-t border-black/10" style="border-top:1px solid rgba(11,116,67,0.2);">

      <div>
        <h1 class="font-bold leading-[0.88] uppercase tracking-tight text-rich-black"
            style="font-size: clamp(3.5rem,11vw,13rem);">
          Cerdas<br>Kelola<br><span style="color:#0b7443;">Keuangan</span>
        </h1>
      </div>

      <hr style="border-top:1px solid rgba(11,116,67,0.2);">

      <div class="flex flex-col md:flex-row items-start md:items-end justify-between gap-8">
        <p class="max-w-[50ch] leading-relaxed text-cool-gray" style="font-size:clamp(1rem,2.2vw,1.6rem);">
          Platform edukasi literasi keuangan untuk masyarakat Indonesia. Hindari jebakan pinjol ilegal & judi online — mulai dari sini.
        </p>
        <div class="flex flex-col sm:flex-row gap-3 flex-shrink-0">
          @auth
            <a href="{{ route('dashboard') }}" class="btn-primary">Ke Dashboard →</a>
          @else
            <a href="{{ route('register') }}" class="btn-primary" style="font-size:1rem;padding:14px 28px;">Daftar Gratis</a>
            <a href="{{ route('login') }}" class="btn-secondary" style="font-size:1rem;padding:14px 28px;">Masuk</a>
          @endauth
        </div>
      </div>

      {{-- Stats Row --}}
      <div class="grid grid-cols-3 gap-4 mt-4">
        <div class="bg-white/70 backdrop-blur rounded-2xl p-5 border border-white/50">
          <p class="text-3xl font-bold text-rich-black">2.263</p>
          <p class="text-xs text-cool-gray mt-1">Pinjol diblokir OJK 2025</p>
        </div>
        <div class="bg-white/70 backdrop-blur rounded-2xl p-5 border border-white/50">
          <p class="text-3xl font-bold" style="color:#0b7443;">Rp 9T</p>
          <p class="text-xs text-cool-gray mt-1">Kerugian judol per tahun</p>
        </div>
        <div class="bg-white/70 backdrop-blur rounded-2xl p-5 border border-white/50">
          <p class="text-3xl font-bold text-rich-black">Gratis</p>
          <p class="text-xs text-cool-gray mt-1">Seluruh konten edukasi</p>
        </div>
      </div>
    </div>
  </section>

  {{-- SECTION 02 — 4 Modul Utama --}}
  <section data-flow-section aria-label="4 Modul Utama"
    class="relative min-h-screen w-full overflow-hidden"
    style="background: #0b7443; color: #fff;">
    <div data-flow-inner class="flow-art-container relative flex min-h-screen w-full flex-col justify-between gap-6 px-[4vw] pt-[clamp(2rem,8vw,4vw)] pb-[4vw]" style="transform-origin: bottom left;">

      <span class="text-xs font-bold uppercase tracking-[0.2em] text-green-200">02 — Modul Pembelajaran</span>

      <hr style="border-top:1px solid rgba(255,255,255,0.25);">

      <div>
        <h2 class="font-bold leading-[0.88] uppercase tracking-tight text-white"
            style="font-size:clamp(3rem,10vw,12rem);">
          4 Modul<br>Utama
        </h2>
      </div>

      <hr style="border-top:1px solid rgba(255,255,255,0.25);">

      <p class="max-w-[50ch] leading-relaxed text-green-100" style="font-size:clamp(1rem,2.2vw,1.6rem);">
        Kurikulum terstruktur dari dasar literasi hingga perlindungan aktif dari ancaman finansial.
      </p>

      <hr style="border-top:1px solid rgba(255,255,255,0.25);">

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @php $modulesData = [
          ['💰','Fondasi','Dasar Literasi Keuangan','Anggaran 50/30/20, menabung, fondasi finansial kuat.','dasar-literasi-keuangan'],
          ['🚫','Waspada','Bahaya Pinjol Ilegal','Kenali ciri pinjol ilegal & dampak bunga majemuk mencekik.','bahaya-pinjol-ilegal'],
          ['🎰','Lindungi','Bahaya Judi Online','Matematika kekalahan judol & strategi keluar kecanduan.','bahaya-judi-online'],
          ['📈','Sejahtera','Pengelolaan Keuangan Sehat','Investasi emas, deposito, dana darurat, reksa dana.','pengelolaan-keuangan-sehat'],
        ]; @endphp
        @foreach($modulesData as [$icon, $tag, $title, $desc, $slug])
        <a href="{{ route('modules.index') }}" class="group flex items-start gap-4 bg-white/10 hover:bg-white/20 rounded-2xl p-5 transition-all border border-white/20">
          <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl flex-shrink-0" style="background:rgba(255,255,255,0.15);">{{ $icon }}</div>
          <div>
            <span class="text-xs font-bold uppercase tracking-wider text-green-200">{{ $tag }}</span>
            <p class="font-bold text-white mt-0.5">{{ $title }}</p>
            <p class="text-sm text-green-100 mt-1">{{ $desc }}</p>
          </div>
          <svg class="w-5 h-5 text-green-200 ml-auto mt-1 group-hover:translate-x-1 transition-transform flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
        @endforeach
      </div>

      <div class="flex justify-center mt-4">
        <a href="{{ route('modules.index') }}" class="btn-secondary" style="background:white;color:#0b7443;border-color:white;">Lihat Semua Modul →</a>
      </div>
    </div>
  </section>

  {{-- SECTION 03 — Fitur Platform --}}
  <section data-flow-section aria-label="Fitur Platform"
    class="relative min-h-screen w-full overflow-hidden"
    style="background: #F5F0E8; color: #000;">
    <div data-flow-inner class="flow-art-container relative flex min-h-screen w-full flex-col justify-between gap-6 px-[4vw] pt-[clamp(2rem,8vw,4vw)] pb-[4vw]" style="transform-origin: bottom left;">

      <span class="text-xs font-bold uppercase tracking-[0.2em] text-cool-gray">03 — Kenapa CerdasFin?</span>

      <hr style="border-top:1px solid rgba(0,0,0,0.15);">

      <div>
        <h2 class="font-bold leading-[0.88] uppercase tracking-tight text-rich-black"
            style="font-size:clamp(3rem,10vw,12rem);">
          Platform<br>Lengkap.<br><span style="color:#0b7443;">Gratis.</span>
        </h2>
      </div>

      <hr style="border-top:1px solid rgba(0,0,0,0.15);">

      <p class="max-w-[50ch] leading-relaxed text-cool-gray" style="font-size:clamp(1rem,2.2vw,1.5rem);">
        Dirancang khusus untuk dampak nyata literasi keuangan masyarakat Indonesia.
      </p>

      <hr style="border-top:1px solid rgba(0,0,0,0.15);">

      <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
        @php $features = [
          ['📊','Pre-test & Post-test','Ukur peningkatan pengetahuan secara akurat sebelum & sesudah belajar.'],
          ['🎮','Gamifikasi & Badge','Kumpulkan poin, raih badge, pertahankan streak belajar harian.'],
          ['🧮','Simulasi Keuangan','Coba simulasi bunga pinjol, tabungan, dan investasi real-time.'],
          ['🏆','Sertifikat Digital','Dapatkan sertifikat otomatis setelah menyelesaikan modul.'],
          ['💬','Forum Komunitas','Diskusi, berbagi tips, dan belajar dari mentor berpengalaman.'],
          ['🛡️','Anti Pinjol & Judol','Edukasi interaktif untuk mengenali & menghindari jebakan finansial.'],
        ]; @endphp
        @foreach($features as [$icon, $title, $desc])
        <div class="bg-white rounded-2xl p-5 border border-black/5 hover:shadow-md transition-shadow">
          <div class="text-3xl mb-3">{{ $icon }}</div>
          <p class="font-bold text-rich-black text-sm mb-1">{{ $title }}</p>
          <p class="text-xs text-cool-gray leading-relaxed">{{ $desc }}</p>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- SECTION 04 — Simulasi Keuangan Teaser --}}
  <section data-flow-section aria-label="Simulasi"
    class="relative min-h-screen w-full overflow-hidden"
    style="background: #000; color: #fff;">
    <div data-flow-inner class="flow-art-container relative flex min-h-screen w-full flex-col justify-between gap-6 px-[4vw] pt-[clamp(2rem,8vw,4vw)] pb-[4vw]" style="transform-origin: bottom left;">

      <span class="text-xs font-bold uppercase tracking-[0.2em] text-gray-400">04 — Simulasi Keuangan</span>

      <hr style="border-top:1px solid rgba(255,255,255,0.15);">

      <div>
        <h2 class="font-bold leading-[0.88] uppercase tracking-tight"
            style="font-size:clamp(3rem,10vw,12rem); color:#61bc76;">
          Hitung<br>Sendiri.<br>Sadar<br>Sendiri.
        </h2>
      </div>

      <hr style="border-top:1px solid rgba(255,255,255,0.15);">

      <p class="max-w-[50ch] leading-relaxed text-gray-300" style="font-size:clamp(1rem,2.2vw,1.5rem);">
        Simulasi interaktif bunga pinjol ilegal, kalkulator investasi aman, dan perencana anggaran 50/30/20.
      </p>

      <hr style="border-top:1px solid rgba(255,255,255,0.15);">

      <div class="flex flex-wrap gap-[3vw]">
        <div class="min-w-[180px] flex-1">
          <p class="mb-2 text-sm font-bold uppercase tracking-wider text-green-400">Bunga Pinjol</p>
          <p class="text-sm leading-relaxed text-gray-400">Lihat sendiri bagaimana Rp 1 Juta bisa menjadi Rp 2.5 Juta dalam 90 hari dengan bunga 1%/hari.</p>
        </div>
        <div class="min-w-[180px] flex-1">
          <p class="mb-2 text-sm font-bold uppercase tracking-wider text-green-400">Investasi Aman</p>
          <p class="text-sm leading-relaxed text-gray-400">Bandingkan hasil tabungan deposito vs reksa dana selama 5-30 tahun dengan compound interest.</p>
        </div>
        <div class="min-w-[180px] flex-1">
          <p class="mb-2 text-sm font-bold uppercase tracking-wider text-green-400">Anggaran 50/30/20</p>
          <p class="text-sm leading-relaxed text-gray-400">Masukkan penghasilanmu, dapatkan rincian alokasi ideal untuk kebutuhan, keinginan & tabungan.</p>
        </div>
      </div>

      <hr style="border-top:1px solid rgba(255,255,255,0.15);">

      <div class="flex justify-start mt-2">
        <a href="{{ route('simulation.index') }}" class="btn-primary" style="background:#61bc76;color:#000;font-size:1rem;padding:14px 28px;">Coba Simulasi Sekarang →</a>
      </div>
    </div>
  </section>

  {{-- SECTION 05 — CTA Join --}}
  <section data-flow-section aria-label="Bergabung"
    class="relative min-h-screen w-full overflow-hidden"
    style="background: linear-gradient(135deg, #0b7443 0%, #095f38 100%); color: #fff;">
    <div data-flow-inner class="flow-art-container relative flex min-h-screen w-full flex-col justify-between gap-6 px-[4vw] pt-[clamp(2rem,8vw,4vw)] pb-[4vw]" style="transform-origin: bottom left;">

      <span class="text-xs font-bold uppercase tracking-[0.2em] text-green-300">05 — Bergabung Sekarang</span>

      <hr style="border-top:1px solid rgba(255,255,255,0.3);">

      <div>
        <h2 class="font-bold leading-[0.88] uppercase tracking-tight text-white"
            style="font-size:clamp(3.5rem,11vw,13rem);">
          Mulai<br>Hari<br>Ini.
        </h2>
      </div>

      <hr style="border-top:1px solid rgba(255,255,255,0.3);">

      <p class="max-w-[50ch] leading-relaxed text-green-100" style="font-size:clamp(1rem,2.2vw,1.6rem);">
        Bergabunglah dan tingkatkan literasi keuanganmu. Gratis selamanya untuk semua masyarakat Indonesia.
      </p>

      <hr style="border-top:1px solid rgba(255,255,255,0.3);">

      <div class="flex flex-wrap gap-4 items-center">
        @auth
          <a href="{{ route('dashboard') }}" class="btn-primary" style="background:white;color:#0b7443;font-size:1rem;padding:16px 32px;font-weight:700;">Ke Dashboard Saya →</a>
          <a href="{{ route('modules.index') }}" class="btn-secondary" style="border-color:rgba(255,255,255,0.5);color:white;font-size:1rem;padding:16px 32px;">Lihat Modul</a>
        @else
          <a href="{{ route('register') }}" class="btn-primary" style="background:white;color:#0b7443;font-size:1rem;padding:16px 32px;font-weight:700;">🌱 Daftar Gratis Sekarang</a>
          <a href="{{ route('login') }}" class="btn-secondary" style="border-color:rgba(255,255,255,0.5);color:white;font-size:1rem;padding:16px 32px;">Sudah Punya Akun? Masuk</a>
        @endauth
      </div>

      <div class="grid grid-cols-3 gap-4 mt-4">
        <div class="bg-white/10 rounded-2xl p-4 text-center">
          <p class="text-2xl font-bold text-white">4</p>
          <p class="text-xs text-green-200 mt-1">Modul Utama</p>
        </div>
        <div class="bg-white/10 rounded-2xl p-4 text-center">
          <p class="text-2xl font-bold text-white">100%</p>
          <p class="text-xs text-green-200 mt-1">Gratis Selamanya</p>
        </div>
        <div class="bg-white/10 rounded-2xl p-4 text-center">
          <p class="text-2xl font-bold text-white">OJK</p>
          <p class="text-xs text-green-200 mt-1">Berbasis Data Resmi</p>
        </div>
      </div>
    </div>
  </section>

</main>
@endsection

@push('head')
{{-- GSAP via CDN (fallback jika npm build belum include) --}}
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>
@endpush

@push('scripts')
<script>
(function() {
  // Register ScrollTrigger plugin
  gsap.registerPlugin(ScrollTrigger);

  // Removed reduced motion check to ensure animation runs.

  const container = document.getElementById('cerdasfin-story');
  if (!container) return;

  const sections = Array.from(container.querySelectorAll('[data-flow-section]'));
  if (sections.length === 0) return;

  const triggers = [];

  sections.forEach((section, i) => {
    // Set stacking z-index
    gsap.set(section, { zIndex: i + 1, position: 'relative' });

    const inner = section.querySelector('.flow-art-container');
    if (!inner) return;

    // All sections after first: start rotated, animate to flat on scroll in
    if (i > 0) {
      gsap.set(inner, { rotation: 28, transformOrigin: 'bottom left' });

      const tween = gsap.to(inner, {
        rotation: 0,
        ease: 'none',
        scrollTrigger: {
          trigger: section,
          start: 'top bottom',
          end: 'top 20%',
          scrub: 1,
        }
      });
      if (tween.scrollTrigger) triggers.push(tween.scrollTrigger);
    }

    // All sections except last: pin while next section scrolls in
    if (i < sections.length - 1) {
      triggers.push(
        ScrollTrigger.create({
          trigger: section,
          start: 'bottom bottom',
          end: 'bottom top',
          pin: true,
          pinSpacing: false,
        })
      );
    }
  });

  ScrollTrigger.refresh();

  // Content fade-in on each section
  sections.forEach((section) => {
    const inner = section.querySelector('.flow-art-container');
    if (!inner) return;

    gsap.fromTo(inner.children,
      { opacity: 0, y: 20 },
      {
        opacity: 1,
        y: 0,
        stagger: 0.08,
        duration: 0.6,
        ease: 'power2.out',
        scrollTrigger: {
          trigger: section,
          start: 'top 80%',
          toggleActions: 'play none none none',
        }
      }
    );
  });
})();
</script>
@endpush
