@extends('layout')
@section('title', 'Perencana Anggaran — CerdasFin')
@section('content')
<div class="container-cf py-12 max-w-2xl">
    <div class="mb-8">
        <div class="badge-green mb-3">💰 Alat Finansial</div>
        <h1 class="text-3xl font-bold text-rich-black">Perencana Anggaran 50/30/20</h1>
        <p class="text-cool-gray mt-1">Rencanakan pengeluaran bulananmu dengan metode yang terbukti efektif</p>
    </div>
    <a href="{{ route('simulation.index') }}" class="btn-primary flex items-center gap-2 w-fit mb-4">
        <span>💰</span> Buka Simulasi Anggaran Lengkap
    </a>
    <p class="text-sm text-cool-gray">Perencana anggaran 50/30/20 tersedia di halaman Simulasi Keuangan.</p>
</div>
@endsection
