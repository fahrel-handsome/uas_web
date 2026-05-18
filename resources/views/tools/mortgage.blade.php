@extends('layout')
@section('title', 'Kalkulator Kredit — CerdasFin')
@section('content')
<div class="container-cf py-12 max-w-2xl">
    <div class="mb-8">
        <div class="badge-peach mb-3">🏠 Alat Finansial</div>
        <h1 class="text-3xl font-bold text-rich-black">Kalkulator Kredit / KPR</h1>
        <p class="text-cool-gray mt-1">Hitung cicilan kredit dengan bunga tetap</p>
    </div>
    <div class="card p-8" x-data="mortgageCalc()">
        <div class="space-y-5 mb-6">
            <div>
                <label class="form-label">Jumlah Pinjaman (Rp)</label>
                <input type="number" x-model="principal" class="form-input" placeholder="200.000.000">
            </div>
            <div>
                <label class="form-label">Bunga Tahunan (%) <span class="text-xs text-cool-gray">KPR subsidi ~5%, komersial ~10-12%</span></label>
                <input type="number" x-model="rate" step="0.1" class="form-input" placeholder="10">
            </div>
            <div>
                <label class="form-label">Tenor (tahun)</label>
                <input type="number" x-model="years" class="form-input" placeholder="15">
            </div>
        </div>
        <button @click="calc()" class="btn-primary w-full justify-center">Hitung Cicilan</button>
        <div x-show="result" class="mt-6 space-y-3">
            <div class="flex justify-between p-4 bg-mint-green-glow border border-leafy-green rounded-xl">
                <span class="font-semibold text-deep-fern-green">Cicilan per Bulan</span>
                <span class="text-xl font-bold text-deep-fern-green">Rp <span x-text="fmt(result?.monthly)"></span></span>
            </div>
            <div class="flex justify-between p-3 bg-subtle-ash rounded-xl"><span class="text-sm text-cool-gray">Total Bayar</span><span class="font-bold">Rp <span x-text="fmt(result?.total)"></span></span></div>
            <div class="flex justify-between p-3 bg-subtle-ash rounded-xl"><span class="text-sm text-cool-gray">Total Bunga</span><span class="font-bold text-red-600">Rp <span x-text="fmt(result?.interest)"></span></span></div>
        </div>
    </div>
    <div class="alert-warning mt-4">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        Pastikan hanya meminjam dari bank/lembaga keuangan resmi yang terdaftar di OJK.
    </div>
</div>
@endsection
@push('scripts')
<script>
function mortgageCalc() {
    return {
        principal: 200000000, rate: 10, years: 15, result: null,
        calc() {
            const r = (+this.rate/100)/12, n = +this.years*12, p = +this.principal;
            const monthly = r === 0 ? p/n : p * (r * Math.pow(1+r,n)) / (Math.pow(1+r,n)-1);
            const total = monthly * n;
            this.result = { monthly: Math.round(monthly), total: Math.round(total), interest: Math.round(total-p) };
        },
        fmt(v) { return v ? v.toLocaleString('id-ID') : '0'; }
    }
}
</script>
@endpush
