@extends('layout')
@section('title', 'Anti Pinjol & Judi Online — CerdasFin')

@section('content')

{{-- Hero --}}
<section class="bg-melon-tint py-16">
    <div class="container-cf text-center">
        <div class="badge-peach mb-4 inline-flex">⚠️ Edukasi Perlindungan</div>
        <h1 class="text-4xl lg:text-5xl font-bold text-rich-black mb-4">Lindungi Dirimu dari<br><span class="text-terra-cotta">Pinjol Ilegal & Judi Online</span></h1>
        <p class="text-cool-gray text-lg max-w-2xl mx-auto">
            2.263 entitas pinjol ilegal diblokir OJK 2025 · Rp 9 Triliun kerugian judol per tahun
        </p>
    </div>
</section>

{{-- Stats Bar --}}
<section class="bg-rich-black py-8">
    <div class="container-cf">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div><p class="text-3xl font-bold text-white">2.263</p><p class="text-gray-400 text-sm">Pinjol diblokir OJK 2025</p></div>
            <div><p class="text-3xl font-bold text-red-400">Rp 9T</p><p class="text-gray-400 text-sm">Kerugian judol/tahun</p></div>
            <div><p class="text-3xl font-bold text-white">4 Juta+</p><p class="text-gray-400 text-sm">Korban pinjol ilegal</p></div>
            <div><p class="text-3xl font-bold text-leafy-green">100%</p><p class="text-gray-400 text-sm">Edukasi gratis CerdasFin</p></div>
        </div>
    </div>
</section>

{{-- Ciri Pinjol Ilegal --}}
<section class="section">
    <div class="container-cf">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <div class="badge-peach mb-4">🚫 Pinjol Ilegal</div>
                <h2 class="text-3xl font-bold text-rich-black mb-4">Kenali Ciri Pinjol Ilegal</h2>
                <p class="text-cool-gray mb-6">Gunakan checklist ini sebelum meminjam dari aplikasi manapun!</p>
                <div class="space-y-3" id="pinjol-checklist">
                    @php $ciriPinjol = [
                        'Tidak terdaftar/berizin OJK',
                        'Bunga harian lebih dari 0.4% per hari',
                        'Akses seluruh kontak & foto di HP',
                        'Pencairan instan tanpa verifikasi ketat',
                        'Penagihan dengan ancaman & kekerasan',
                        'Tidak ada alamat kantor yang jelas',
                        'Promosi via WhatsApp/SMS spam',
                        'Nama aplikasi mirip pinjol resmi',
                    ]; @endphp
                    @foreach($ciriPinjol as $i => $ciri)
                    <label class="flex items-center gap-3 p-4 bg-subtle-ash rounded-xl cursor-pointer hover:bg-red-50 transition-colors group" x-data="{checked:false}">
                        <input type="checkbox" x-model="checked" class="w-5 h-5 accent-red-600 rounded">
                        <span class="text-sm font-medium text-rich-black" :class="{'line-through text-cool-gray': checked}">{{ $ciri }}</span>
                        <span x-show="checked" class="ml-auto text-red-600 text-xs font-bold">⚠️ Bahaya!</span>
                    </label>
                    @endforeach
                </div>
                <div class="alert-warning mt-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    Jika ada 1 tanda saja, <strong>JANGAN PINJAM!</strong> Laporkan ke OJK 157.
                </div>
            </div>
            <div class="card p-8">
                <h3 class="font-bold text-rich-black mb-4">📊 Dampak Bunga Pinjol Ilegal</h3>
                <div class="space-y-4 text-sm text-cool-gray">
                    <div class="p-4 bg-subtle-ash rounded-xl">
                        <p class="font-semibold text-rich-black mb-1">Contoh: Pinjam Rp 1 Juta</p>
                        <div class="space-y-2 mt-2">
                            <div class="flex justify-between"><span>Bunga harian 1%</span><span class="font-bold text-red-600">Rp 300.000/bulan</span></div>
                            <div class="flex justify-between"><span>Setelah 3 bulan</span><span class="font-bold text-red-600">Hutang Rp 1.9 Juta</span></div>
                            <div class="flex justify-between"><span>Setelah 6 bulan</span><span class="font-bold text-red-600">Hutang Rp 5.7 Juta</span></div>
                        </div>
                    </div>
                    <div class="p-4 bg-mint-green-glow rounded-xl">
                        <p class="font-semibold text-deep-fern-green mb-1">✅ Alternatif Aman</p>
                        <ul class="space-y-1">
                            <li>• Koperasi simpan pinjam resmi</li>
                            <li>• Bank dengan KUR (bunga 6%/tahun)</li>
                            <li>• Pinjol OJK (cek di www.ojk.go.id)</li>
                        </ul>
                    </div>
                </div>
                <a href="{{ route('simulation.index') }}" class="btn-primary w-full justify-center mt-4 text-sm">
                    🔢 Coba Simulasi Bunga Pinjol
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Anti Judol --}}
<section class="section-alt">
    <div class="container-cf">
        <div class="text-center mb-10">
            <div class="badge-peach mb-3">🎰 Judi Online</div>
            <h2 class="text-3xl font-bold text-rich-black mb-3">Matematika Judi Online: Kamu Pasti Kalah</h2>
            <p class="text-cool-gray max-w-xl mx-auto">Ini bukan opini — ini matematika. House edge memastikan platform selalu menang dalam jangka panjang.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="card p-6 text-center">
                <div class="text-4xl mb-3">🎰</div>
                <h3 class="font-bold text-rich-black mb-2">Slot Online</h3>
                <p class="text-3xl font-bold text-red-600 mb-1">5-15%</p>
                <p class="text-sm text-cool-gray">House Edge — Platform ambil 5-15% dari setiap taruhan</p>
            </div>
            <div class="card p-6 text-center">
                <div class="text-4xl mb-3">🃏</div>
                <h3 class="font-bold text-rich-black mb-2">Poker Online</h3>
                <p class="text-3xl font-bold text-red-600 mb-1">2-10%</p>
                <p class="text-sm text-cool-gray">Rake — Potongan dari setiap pot yang dimainkan</p>
            </div>
            <div class="card p-6 text-center">
                <div class="text-4xl mb-3">⚽</div>
                <h3 class="font-bold text-rich-black mb-2">Taruhan Bola</h3>
                <p class="text-3xl font-bold text-red-600 mb-1">3-8%</p>
                <p class="text-sm text-cool-gray">Margin — Odds diset agar bandar selalu untung</p>
            </div>
        </div>
        <div class="card-peach p-8 rounded-2xl">
            <h3 class="font-bold text-rich-black mb-4">🧮 Simulasi: Bertaruh Rp 100.000 / hari selama 1 tahun</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div class="bg-white/70 p-4 rounded-xl">
                    <p class="font-semibold text-rich-black">Total Taruhan</p>
                    <p class="text-2xl font-bold text-rich-black">Rp 36,5 Juta</p>
                </div>
                <div class="bg-white/70 p-4 rounded-xl">
                    <p class="font-semibold text-red-600">Estimasi Kerugian (10%)</p>
                    <p class="text-2xl font-bold text-red-600">Rp 3,65 Juta</p>
                </div>
                <div class="bg-white/70 p-4 rounded-xl">
                    <p class="font-semibold text-deep-fern-green">Jika Investasi (8%/tahun)</p>
                    <p class="text-2xl font-bold text-deep-fern-green">+Rp 39,4 Juta</p>
                </div>
            </div>
            <p class="text-sm text-terra-cotta mt-4 font-medium">⚠️ Selisih: Rp 43 Juta — Pilihan ada di tanganmu.</p>
        </div>
    </div>
</section>

{{-- Cara Lapor --}}
<section class="section">
    <div class="container-cf text-center">
        <h2 class="text-3xl font-bold text-rich-black mb-4">Sudah Jadi Korban? Laporkan!</h2>
        <p class="text-cool-gray mb-8">Jangan diam. Laporkan pinjol ilegal dan judi online ke pihak berwenang.</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-3xl mx-auto">
            <div class="card p-6 text-center">
                <div class="text-3xl mb-3">📞</div>
                <h3 class="font-bold text-rich-black mb-1">OJK</h3>
                <p class="text-deep-fern-green font-bold text-xl">157</p>
                <p class="text-xs text-cool-gray">Hotline OJK 24 jam</p>
            </div>
            <div class="card p-6 text-center">
                <div class="text-3xl mb-3">🌐</div>
                <h3 class="font-bold text-rich-black mb-1">Lapor Online</h3>
                <p class="text-deep-fern-green font-bold text-sm">www.ojk.go.id</p>
                <p class="text-xs text-cool-gray">Formulir pengaduan online</p>
            </div>
            <div class="card p-6 text-center">
                <div class="text-3xl mb-3">🚔</div>
                <h3 class="font-bold text-rich-black mb-1">Polisi</h3>
                <p class="text-deep-fern-green font-bold text-xl">110</p>
                <p class="text-xs text-cool-gray">Ancaman & intimidasi</p>
            </div>
        </div>
    </div>
</section>

@endsection
