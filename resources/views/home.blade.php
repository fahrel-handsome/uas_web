@extends('layout')

@section('content')
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
                <div>
                    <h1 class="text-5xl font-bold mb-6">Kuasai Keuanganmu, Bangun Masa Depan Cerah Bersama CerdasFin!</h1>
                    <p class="text-xl mb-8 text-blue-100">Aset modul keuangan terencana, dari perencanaan anggaran hingga investasi cerdas. Kami di sini untuk membuat Anda menjadi ahli keuangan.</p>
                    <div class="flex space-x-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition">Lanjut Belajar</a>
                        @else
                            <a href="{{ route('register') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition">Daftar Gratis</a>
                            <a href="{{ route('login') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition">Masuk</a>
                        @endauth
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl p-8 text-center">
                        <svg class="w-32 h-32 mx-auto text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-white text-xl font-semibold mt-4">Raih 1000+ Pengguna</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modules Section -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center mb-12">Pusat Pembelajaran Keuangan Terpadu</h2>
            <p class="text-center text-gray-600 mb-12 text-lg">CerdasFin adalah solusi platform belajar. Kami adalah ekosistem digital yang dirancang untuk membuat Anda dengan dan pengaturan praktis untuk mengelola uang secara bijak.</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <div class="bg-white rounded-lg shadow-lg p-8 text-center hover:shadow-xl transition">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747 0-6.002-4.5-10.747-10-10.747z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Modul Terstruktur</h3>
                    <p class="text-gray-600">Materi dari dasar hingga mahir yang disusun dari hingga ahli keuangan Indonesia.</p>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-8 text-center hover:shadow-xl transition">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Kuis & Assessment</h3>
                    <p class="text-gray-600">Uji pemahaman Anda dengan kuis interaktif setelah setiap topik untuk evaluasi keterampilan.</p>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-8 text-center hover:shadow-xl transition">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Alat Finansial</h3>
                    <p class="text-gray-600">Akses kalkulator investasi, perencanaan anggaran, dan simulasi keuangan untuk analisis mendalam.</p>
                </div>
            </div>

            <!-- Modules Grid -->
            @if($modules->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach($modules as $module)
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                            <div class="bg-gradient-to-r from-blue-600 to-blue-800 h-32 flex items-center justify-center">
                                <svg class="w-16 h-16 text-white opacity-30" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.5 1.5H3.75A2.25 2.25 0 001.5 3.75v12.5A2.25 2.25 0 003.75 18.5h12.5a2.25 2.25 0 002.25-2.25V9.5M6.5 6.5h7M6.5 10h7M6.5 13.5h4" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"></path>
                                </svg>
                            </div>
                            <div class="p-6">
                                <h3 class="text-2xl font-bold mb-2">{{ $module->title }}</h3>
                                <p class="text-gray-600 mb-4">{{ Str::limit($module->description, 100) }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-blue-600 font-semibold">{{ $module->courses()->count() }} Kursus</span>
                                    <a href="{{ route('courses.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold">Lihat Kursus →</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- Popular Courses -->
    <section class="py-20 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center mb-12">Kursus Populer</h2>

            @if($popularCourses->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($popularCourses as $course)
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                            @if($course->thumbnail)
                                <img src="{{ $course->thumbnail }}" alt="{{ $course->title }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gradient-to-br from-blue-400 to-blue-600"></div>
                            @endif
                            <div class="p-6">
                                <h3 class="text-xl font-bold mb-2">{{ $course->title }}</h3>
                                <p class="text-gray-600 text-sm mb-4">{{ $course->module->title }}</p>
                                <p class="text-gray-600 mb-4">{{ Str::limit($course->description, 80) }}</p>
                                <div class="flex justify-between items-center">
                                    @if($course->duration_minutes)
                                        <span class="text-sm text-gray-500">⏱️ {{ $course->duration_minutes }} menit</span>
                                    @endif
                                    <a href="{{ route('courses.show', $course) }}" class="text-blue-600 hover:text-blue-800 font-semibold">Mulai →</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="text-center mt-12">
                <a href="{{ route('courses.index') }}" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition inline-block">Lihat Semua Kursus</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center mb-12">Fitur Unggulan Kami</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="flex space-x-4">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h-2m0 0H8m4 0v2m0-2v-2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold">Simulasi Keuangan</h3>
                        <p class="text-gray-600 mt-2">Uji skenario keuangan Anda dalam lingkungan simulasi yang aman.</p>
                    </div>
                </div>

                <div class="flex space-x-4">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold">Analitik & Grafik</h3>
                        <p class="text-gray-600 mt-2">Visualisasi kemajuan dan performa keuangan Anda dengan grafik interaktif.</p>
                    </div>
                </div>

                <div class="flex space-x-4">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10h.01M13 16h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold">Forum Diskusi</h3>
                        <p class="text-gray-600 mt-2">Berbagi pengalaman dan tanya jawab dengan komunitas finansial.</p>
                    </div>
                </div>

                <div class="flex space-x-4">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m7 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold">Gamifikasi & Sertifikat</h3>
                        <p class="text-gray-600 mt-2">Dapatkan badge, poin, dan sertifikat setelah menyelesaikan kursus.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-blue-600 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold mb-4">Siap Memulai Perjalanan Keuanganmu?</h2>
            <p class="text-xl mb-8 text-blue-100">Bergabunglah dengan ribuan orang lainnya yang telah berhubungan mengubah cara mereka mengelola uang.</p>
            @auth
                <a href="{{ route('dashboard') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition inline-block">Masuk ke Dashboard</a>
            @else
                <a href="{{ route('register') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition inline-block">Daftar Sekarang Gratis</a>
            @endauth
        </div>
    </section>
@endsection
