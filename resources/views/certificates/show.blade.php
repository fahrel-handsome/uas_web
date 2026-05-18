@extends('layout')

@section('title', 'Sertifikat - ' . $certificate->course->title)

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <a href="{{ route('certificates.index') }}" class="text-blue-600 hover:text-blue-800 mb-8 inline-block">← Kembali ke Sertifikat Saya</a>

        <div class="flex justify-center">
            <div class="w-full max-w-4xl bg-gradient-to-br from-amber-50 via-yellow-50 to-amber-50 border-8 border-amber-900 rounded-lg shadow-2xl p-12">
                <!-- Certificate Header -->
                <div class="text-center mb-8">
                    <div class="flex justify-center mb-4">
                        <svg class="w-24 h-24 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                    <h1 class="text-4xl font-bold text-amber-900 mb-2">Sertifikat Penghargaan</h1>
                    <p class="text-amber-800 text-xl">Diberikan dengan kehormatan atas pencapaian luar biasa</p>
                </div>

                <!-- Certificate Body -->
                <div class="border-t-4 border-b-4 border-amber-800 py-12 mb-12">
                    <p class="text-center text-amber-900 text-lg mb-4">Ini membuktikan bahwa</p>
                    <p class="text-center text-4xl font-bold text-amber-900 mb-6">{{ Auth::user()->name }}</p>
                    <p class="text-center text-amber-900 text-lg">telah berhasil menyelesaikan kursus</p>
                    <p class="text-center text-3xl font-bold text-amber-900 mt-4">{{ $certificate->course->title }}</p>
                    <p class="text-center text-amber-900 text-lg mt-4">dengan hasil yang memuaskan</p>
                </div>

                <!-- Certificate Details -->
                <div class="grid grid-cols-3 gap-8 mb-8">
                    <div class="text-center">
                        <p class="text-amber-800 text-sm mb-1">Nomor Sertifikat</p>
                        <p class="text-amber-900 font-mono font-bold">{{ $certificate->certificate_number }}</p>
                    </div>
                    <div class="text-center border-l border-r border-amber-800">
                        <p class="text-amber-800 text-sm mb-1">Tanggal Diterbitkan</p>
                        <p class="text-amber-900 font-bold">{{ $certificate->issued_at->format('d M Y') }}</p>
                    </div>
                    <div class="text-center">
                        <p class="text-amber-800 text-sm mb-1">Berlaku Hingga</p>
                        <p class="text-amber-900 font-bold">{{ $certificate->expires_at ? $certificate->expires_at->format('d M Y') : 'Selamanya' }}</p>
                    </div>
                </div>

                <!-- Signature -->
                <div class="flex justify-around mb-8">
                    <div class="text-center">
                        <div class="w-24 h-16 border-t border-amber-900 mb-2"></div>
                        <p class="text-amber-900 font-bold">Kepala Pendidikan</p>
                        <p class="text-amber-800 text-sm">CerdasFin</p>
                    </div>
                    <div class="text-center">
                        <div class="w-24 h-16 border-t border-amber-900 mb-2"></div>
                        <p class="text-amber-900 font-bold">Direktur</p>
                        <p class="text-amber-800 text-sm">CerdasFin</p>
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center text-amber-800 text-sm">
                    <p>Sertifikat ini adalah bukti resmi penyelesaian kursus.</p>
                    <p>Dapat diverifikasi di www.cerdasfin.id</p>
                </div>
            </div>
        </div>

        <!-- Print & Download -->
        <div class="text-center mt-12">
            <button onclick="window.print()" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition font-semibold">🖨️ Cetak / Unduh PDF</button>
        </div>
    </div>
@endsection
