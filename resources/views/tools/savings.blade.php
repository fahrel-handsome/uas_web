@extends('layout')
@section('title', 'Kalkulator Tabungan — CerdasFin')
@section('content')
<div class="container-cf py-12 max-w-2xl">
    <div class="mb-8">
        <div class="badge-green mb-3">🏦 Alat Finansial</div>
        <h1 class="text-3xl font-bold text-rich-black">Kalkulator Tabungan</h1>
        <p class="text-cool-gray mt-1">Hitung proyeksi tabunganmu dengan bunga majemuk</p>
    </div>
    <div class="card p-8" x-data="savingsCalc()">
        <div class="space-y-5 mb-6">
            <div>
                <label class="form-label">Tabungan Awal (Rp)</label>
                <input type="number" x-model="principal" class="form-input" placeholder="1.000.000">
            </div>
            <div>
                <label class="form-label">Setoran Bulanan (Rp)</label>
                <input type="number" x-model="monthly" class="form-input" placeholder="500.000">
            </div>
            <div>
                <label class="form-label">Bunga Tahunan (%)</label>
                <input type="number" x-model="rate" step="0.1" class="form-input" placeholder="5">
                <p class="text-xs text-cool-gray mt-1">Deposito bank ~4-6%, tabungan biasa ~2-3%</p>
            </div>
            <div>
                <label class="form-label">Jangka Waktu (tahun)</label>
                <input type="number" x-model="years" class="form-input" placeholder="5">
            </div>
        </div>
        <button @click="calc()" class="btn-primary w-full justify-center">Hitung Tabungan</button>

        <div x-show="result" class="mt-6 space-y-3">
            <div class="flex justify-between p-3 bg-subtle-ash rounded-xl"><span class="text-sm text-cool-gray">Total Setor</span><span class="font-bold">Rp <span x-text="fmt(result?.deposited)"></span></span></div>
            <div class="flex justify-between p-3 bg-subtle-ash rounded-xl"><span class="text-sm text-cool-gray">Total Bunga</span><span class="font-bold text-deep-fern-green">Rp <span x-text="fmt(result?.interest)"></span></span></div>
            <div class="flex justify-between p-4 bg-mint-green-glow border border-leafy-green rounded-xl"><span class="font-semibold text-deep-fern-green">Total Tabungan 🎉</span><span class="text-xl font-bold text-deep-fern-green">Rp <span x-text="fmt(result?.total)"></span></span></div>
        </div>
    </div>
    <div class="mt-4 text-center">
        <a href="{{ route('simulation.index') }}" class="text-sm text-deep-fern-green hover:underline">← Lihat Simulasi Lebih Lengkap</a>
    </div>
</div>
@endsection
@push('scripts')
<script>
function savingsCalc() {
    return {
        principal: 1000000, monthly: 500000, rate: 5, years: 5, result: null,
        calc() {
            let balance = +this.principal;
            const m = +this.monthly, r = (+this.rate/100)/12, months = +this.years*12;
            const deposited = +this.principal + m * months;
            for(let i = 0; i < months; i++) balance = balance * (1+r) + m;
            this.result = { total: Math.round(balance), deposited: Math.round(deposited), interest: Math.round(balance - deposited) };
        },
        fmt(v) { return v ? v.toLocaleString('id-ID') : '0'; }
    }
}
</script>
@endpush
