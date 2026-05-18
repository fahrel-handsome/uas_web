<!DOCTYPE html>
<html lang="id" x-data="{ mobileOpen: false, userDropOpen: false, toolDropOpen: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CerdasFin — Platform Literasi Keuangan')</title>
    <meta name="description" content="@yield('meta_description', 'Belajar literasi keuangan, hindari pinjol ilegal & judi online bersama CerdasFin. Platform edukasi finansial terpercaya untuk masyarakat Indonesia.')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    @stack('head')
</head>
<body class="bg-canvas-white font-pp-neue-montreal antialiased">

    <!-- ===== NAVBAR ===== -->
    <nav class="sticky top-0 z-40 bg-canvas-white border-b border-gray-100" style="box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
        <div class="container-cf">
            <div class="flex items-center justify-between h-16">

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <div class="w-8 h-8 bg-deep-fern-green rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold tracking-tight">
                        <span class="text-deep-fern-green">Cerdas</span><span class="text-terra-cotta">Fin</span>
                    </span>
                </a>

                {{-- Desktop Nav --}}
                <div class="hidden lg:flex items-center gap-1">
                    <a href="{{ route('home') }}" class="nav-link px-3 py-2 rounded-lg hover:bg-mint-green-glow {{ request()->routeIs('home') ? 'text-deep-fern-green bg-mint-green-glow' : '' }}">Beranda</a>
                    <a href="{{ route('courses.index') }}" class="nav-link px-3 py-2 rounded-lg hover:bg-mint-green-glow {{ request()->routeIs('courses.*') ? 'text-deep-fern-green bg-mint-green-glow' : '' }}">Kursus</a>
                    <a href="{{ route('modules.index') }}" class="nav-link px-3 py-2 rounded-lg hover:bg-mint-green-glow {{ request()->routeIs('modules.*') ? 'text-deep-fern-green bg-mint-green-glow' : '' }}">Modul</a>
                    <a href="{{ route('forum.index') }}" class="nav-link px-3 py-2 rounded-lg hover:bg-mint-green-glow {{ request()->routeIs('forum.*') ? 'text-deep-fern-green bg-mint-green-glow' : '' }}">Forum</a>

                    {{-- Dropdown: Alat Finansial --}}
                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button class="nav-link px-3 py-2 rounded-lg hover:bg-mint-green-glow flex items-center gap-1">
                            Simulasi
                            <svg class="w-3.5 h-3.5 text-cool-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="absolute left-0 mt-1 w-56 bg-canvas-white rounded-2xl border border-gray-100 py-2 z-50" style="box-shadow: 0 8px 24px rgba(0,0,0,0.1);">
                            <a href="{{ route('simulation.index') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-mint-green-glow text-cool-gray hover:text-deep-fern-green text-sm">
                                <span class="text-lg">📊</span> Simulasi Keuangan
                            </a>
                            <a href="{{ route('tools.savings') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-mint-green-glow text-cool-gray hover:text-deep-fern-green text-sm">
                                <span class="text-lg">🏦</span> Kalkulator Tabungan
                            </a>
                            <a href="{{ route('tools.investment') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-mint-green-glow text-cool-gray hover:text-deep-fern-green text-sm">
                                <span class="text-lg">📈</span> Kalkulator Investasi
                            </a>
                            <a href="{{ route('tools.budget') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-mint-green-glow text-cool-gray hover:text-deep-fern-green text-sm">
                                <span class="text-lg">💰</span> Perencana Anggaran
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('awareness.index') }}" class="nav-link px-3 py-2 rounded-lg hover:bg-melon-tint hover:text-terra-cotta flex items-center gap-1 {{ request()->routeIs('awareness.*') ? 'text-terra-cotta bg-melon-tint' : '' }}">
                        <span class="text-sm">⚠️</span> Anti Pinjol & Judol
                    </a>
                </div>

                {{-- Right Section --}}
                <div class="hidden lg:flex items-center gap-3">
                    @auth
                        {{-- User Dropdown --}}
                        <div class="relative" x-data="{ open: false }" @click.away="open = false">
                            <button @click="open = !open" class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-subtle-ash transition-colors">
                                <div class="avatar w-8 h-8 text-xs">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div class="text-left hidden xl:block">
                                    <p class="text-sm font-medium text-rich-black leading-none">{{ Str::limit(Auth::user()->name, 15) }}</p>
                                    @if(Auth::user()->userPoints)
                                        <p class="text-xs text-deep-fern-green">{{ Auth::user()->userPoints->total_points }} poin</p>
                                    @endif
                                </div>
                                <svg class="w-4 h-4 text-cool-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="absolute right-0 mt-2 w-56 bg-canvas-white rounded-2xl border border-gray-100 py-2 z-50" style="box-shadow: 0 8px 24px rgba(0,0,0,0.1);">
                                <div class="px-4 py-3 border-b border-gray-100 mb-1">
                                    <p class="text-sm font-semibold text-rich-black">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-cool-gray truncate">{{ Auth::user()->email }}</p>
                                </div>
                                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-mint-green-glow text-cool-gray hover:text-deep-fern-green text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                    Dashboard
                                </a>
                                <a href="{{ route('certificates.index') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-mint-green-glow text-cool-gray hover:text-deep-fern-green text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                                    Sertifikat Saya
                                </a>
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-mint-green-glow text-cool-gray hover:text-deep-fern-green text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    Profil
                                </a>
                                @if(Auth::user()->role === 'admin')
                                <div class="border-t border-gray-100 mt-1 mb-1"></div>
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-melon-tint text-terra-cotta text-sm font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    Admin Panel
                                </a>
                                @endif
                                <div class="border-t border-gray-100 mt-1 pt-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex items-center gap-3 w-full px-4 py-2.5 hover:bg-red-50 text-red-600 text-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                            Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="nav-link px-3 py-2">Masuk</a>
                        <a href="{{ route('register') }}" class="btn-primary text-sm py-2 px-4">Daftar Gratis</a>
                    @endauth
                </div>

                {{-- Mobile hamburger --}}
                <button @click="mobileOpen = !mobileOpen" class="lg:hidden p-2 rounded-lg hover:bg-subtle-ash">
                    <svg x-show="!mobileOpen" class="w-6 h-6 text-rich-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="mobileOpen" class="w-6 h-6 text-rich-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="lg:hidden border-t border-gray-100 bg-canvas-white">
            <div class="container-cf py-4 flex flex-col gap-1">
                <a href="{{ route('home') }}" @click="mobileOpen=false" class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-mint-green-glow text-cool-gray hover:text-deep-fern-green font-medium">🏠 Beranda</a>
                <a href="{{ route('courses.index') }}" @click="mobileOpen=false" class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-mint-green-glow text-cool-gray hover:text-deep-fern-green font-medium">📚 Kursus</a>
                <a href="{{ route('modules.index') }}" @click="mobileOpen=false" class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-mint-green-glow text-cool-gray hover:text-deep-fern-green font-medium">🎓 Modul</a>
                <a href="{{ route('forum.index') }}" @click="mobileOpen=false" class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-mint-green-glow text-cool-gray hover:text-deep-fern-green font-medium">💬 Forum</a>
                <a href="{{ route('simulation.index') }}" @click="mobileOpen=false" class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-mint-green-glow text-cool-gray hover:text-deep-fern-green font-medium">📊 Simulasi Keuangan</a>
                <a href="{{ route('tools.savings') }}" @click="mobileOpen=false" class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-mint-green-glow text-cool-gray hover:text-deep-fern-green font-medium">🏦 Kalkulator Tabungan</a>
                <a href="{{ route('tools.investment') }}" @click="mobileOpen=false" class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-mint-green-glow text-cool-gray hover:text-deep-fern-green font-medium">📈 Kalkulator Investasi</a>
                <a href="{{ route('awareness.index') }}" @click="mobileOpen=false" class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-melon-tint text-cool-gray hover:text-terra-cotta font-medium">⚠️ Anti Pinjol & Judol</a>
                @auth
                    <div class="border-t border-gray-100 my-2"></div>
                    <a href="{{ route('dashboard') }}" @click="mobileOpen=false" class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-mint-green-glow text-cool-gray hover:text-deep-fern-green font-medium">⚡ Dashboard</a>
                    <a href="{{ route('certificates.index') }}" @click="mobileOpen=false" class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-mint-green-glow text-cool-gray hover:text-deep-fern-green font-medium">🏆 Sertifikat Saya</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-3 w-full px-3 py-3 rounded-xl hover:bg-red-50 text-red-600 font-medium">🚪 Keluar</button>
                    </form>
                @else
                    <div class="border-t border-gray-100 my-2"></div>
                    <a href="{{ route('login') }}" @click="mobileOpen=false" class="btn-ghost w-full text-center">Masuk</a>
                    <a href="{{ route('register') }}" @click="mobileOpen=false" class="btn-primary w-full text-center">Daftar Gratis</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="container-cf pt-4" id="flash-success">
            <div class="alert-success">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                {{ session('success') }}
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="container-cf pt-4" id="flash-error">
            <div class="alert-error">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('error') }}
            </div>
        </div>
    @endif

    {{-- Main Content --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-rich-black text-gray-400 pt-16 pb-8">
        <div class="container-cf">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
                {{-- Brand --}}
                <div class="lg:col-span-1">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-deep-fern-green rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-white text-xl font-bold"><span class="text-leafy-green">Cerdas</span>Fin</span>
                    </div>
                    <p class="text-sm leading-relaxed mb-4">Platform edukasi literasi keuangan untuk masyarakat Indonesia. Lindungi dirimu dari pinjol ilegal & judi online.</p>
                    <div class="badge-green inline-flex">🛡️ Platform Terpercaya</div>
                </div>

                {{-- Navigasi --}}
                <div>
                    <h4 class="text-white font-semibold mb-4 text-sm tracking-wider uppercase">Navigasi</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="{{ route('courses.index') }}" class="hover:text-white transition-colors">Semua Kursus</a></li>
                        <li><a href="{{ route('modules.index') }}" class="hover:text-white transition-colors">Modul Belajar</a></li>
                        <li><a href="{{ route('forum.index') }}" class="hover:text-white transition-colors">Forum Diskusi</a></li>
                        <li><a href="{{ route('awareness.index') }}" class="hover:text-white transition-colors">Anti Pinjol & Judol</a></li>
                    </ul>
                </div>

                {{-- Simulasi --}}
                <div>
                    <h4 class="text-white font-semibold mb-4 text-sm tracking-wider uppercase">Alat Finansial</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('simulation.index') }}" class="hover:text-white transition-colors">Simulasi Keuangan</a></li>
                        <li><a href="{{ route('tools.savings') }}" class="hover:text-white transition-colors">Kalkulator Tabungan</a></li>
                        <li><a href="{{ route('tools.investment') }}" class="hover:text-white transition-colors">Kalkulator Investasi</a></li>
                        <li><a href="{{ route('tools.budget') }}" class="hover:text-white transition-colors">Perencana Anggaran</a></li>
                        <li><a href="{{ route('tools.mortgage') }}" class="hover:text-white transition-colors">Kalkulator Kredit</a></li>
                    </ul>
                </div>

                {{-- Kontak --}}
                <div>
                    <h4 class="text-white font-semibold mb-4 text-sm tracking-wider uppercase">Informasi</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li class="flex items-center gap-2"><span>📧</span> info@cerdasfin.id</li>
                        <li class="flex items-center gap-2"><span>📍</span> Jakarta, Indonesia</li>
                    </ul>
                    <div class="mt-4 p-3 bg-white/5 rounded-xl border border-white/10">
                        <p class="text-xs text-gray-500 mb-1">Data OJK 2025</p>
                        <p class="text-xs text-white font-medium">2.263 entitas pinjol ilegal telah diblokir</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-xs">© 2025 CerdasFin. Hak cipta dilindungi undang-undang.</p>
                <div class="flex items-center gap-4 text-xs">
                    <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                    <a href="#" class="hover:text-white transition-colors">Tentang Kami</a>
                </div>
            </div>
        </div>
    </footer>

    {{-- Auto-dismiss flash --}}
    <script>
        setTimeout(() => {
            ['flash-success','flash-error'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.style.opacity = '0', el.style.transition = 'opacity 0.5s', setTimeout(() => el.remove(), 500);
            });
        }, 4000);
    </script>

    @stack('scripts')
</body>
</html>
