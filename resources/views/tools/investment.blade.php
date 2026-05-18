@extends('layout')
@section('title', 'Kalkulator Investasi — CerdasFin')
@section('content')
<div class="container-cf py-12 max-w-2xl">
    <div class="mb-8">
        <div class="badge-green mb-3">📈 Alat Finansial</div>
        <h1 class="text-3xl font-bold text-rich-black">Kalkulator Investasi</h1>
        <p class="text-cool-gray mt-1">Proyeksikan pertumbuhan investasimu</p>
    </div>
    <a href="{{ route('simulation.index') }}" class="btn-primary flex items-center gap-2 w-fit mb-4">
        <span>📊</span> Coba Simulasi Investasi Lengkap (dengan Chart)
    </a>
    <p class="text-sm text-cool-gray">Halaman simulasi lengkap tersedia di atas dengan visualisasi grafik tahunan.</p>
</div>
@endsection
