@extends('layout')
@section('title', 'Simulasi Keuangan — CerdasFin')

@section('content')
<div class="container-cf py-12">
    <div class="mb-10 text-center">
        <div class="badge-green mb-3">🔢 Interaktif</div>
        <h1 class="text-4xl font-bold text-rich-black mb-2">Simulasi Keuangan</h1>
        <p class="text-cool-gray text-lg max-w-xl mx-auto">Coba simulasi bunga pinjol, investasi aman, dan anggaran bulanan secara real-time</p>
    </div>

    {{-- Tabs --}}
    <div x-data="{ tab: 'pinjol' }">
        <div class="flex gap-2 bg-subtle-ash p-1 rounded-xl max-w-lg mx-auto mb-10">
            <button @click="tab='pinjol'" :class="tab==='pinjol' ? 'bg-canvas-white shadow text-rich-black' : 'text-cool-gray'" class="flex-1 py-2 rounded-lg text-sm font-medium transition-all">🚫 Pinjol Ilegal</button>
            <button @click="tab='investasi'" :class="tab==='investasi' ? 'bg-canvas-white shadow text-rich-black' : 'text-cool-gray'" class="flex-1 py-2 rounded-lg text-sm font-medium transition-all">📈 Investasi</button>
            <button @click="tab='anggaran'" :class="tab==='anggaran' ? 'bg-canvas-white shadow text-rich-black' : 'text-cool-gray'" class="flex-1 py-2 rounded-lg text-sm font-medium transition-all">💰 Anggaran</button>
        </div>

        {{-- Tab: Pinjol --}}
        <div x-show="tab==='pinjol'" x-data="pinjolSim()">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="card p-8">
                    <h2 class="font-bold text-rich-black text-xl mb-6">🚫 Simulasi Bunga Pinjol Ilegal</h2>
                    <div class="space-y-5">
                        <div>
                            <label class="form-label">Jumlah Pinjaman</label>
                            <div class="relative"><span class="absolute left-3 top-1/2 -translate-y-1/2 text-cool-gray text-sm">Rp</span>
                            <input type="number" x-model="principal" min="100000" step="100000" class="form-input pl-10" placeholder="1.000.000"></div>
                        </div>
                        <div>
                            <label class="form-label">Bunga Harian (%)</label>
                            <input type="number" x-model="dailyRate" min="0.1" max="10" step="0.1" class="form-input">
                            <p class="text-xs text-cool-gray mt-1">Pinjol ilegal biasanya 1-3% per hari</p>
                        </div>
                        <div>
                            <label class="form-label">Durasi (hari)</label>
                            <input type="number" x-model="days" min="7" max="365" class="form-input">
                        </div>
                        <button @click="calculate()" class="btn-danger w-full justify-center">
                            Hitung Bahaya Pinjol
                        </button>
                    </div>
                </div>
                <div x-show="result" class="card p-8">
                    <h2 class="font-bold text-rich-black text-xl mb-4">📊 Hasil Simulasi</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between p-3 bg-subtle-ash rounded-xl"><span class="text-sm text-cool-gray">Pinjaman Awal</span><span class="font-bold text-rich-black">Rp <span x-text="fmt(result?.principal)"></span></span></div>
                        <div class="flex justify-between p-3 bg-subtle-ash rounded-xl"><span class="text-sm text-cool-gray">Total Bunga</span><span class="font-bold text-red-600">Rp <span x-text="fmt(result?.total_interest)"></span></span></div>
                        <div class="flex justify-between p-4 bg-red-50 border border-red-200 rounded-xl"><span class="text-sm font-semibold text-red-700">Total Hutang!</span><span class="text-xl font-bold text-red-700">Rp <span x-text="fmt(result?.total_debt)"></span></span></div>
                        <div class="alert-warning"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>Bungamu <span x-text="result?.interest_ratio"></span>% dari pokok pinjaman!</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tab: Investasi --}}
        <div x-show="tab==='investasi'" x-data="investasiSim()">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="card p-8">
                    <h2 class="font-bold text-rich-black text-xl mb-6">📈 Simulasi Investasi Aman</h2>
                    <div class="space-y-5">
                        <div>
                            <label class="form-label">Modal Awal</label>
                            <div class="relative"><span class="absolute left-3 top-1/2 -translate-y-1/2 text-cool-gray text-sm">Rp</span><input type="number" x-model="principal" class="form-input pl-10" placeholder="1.000.000"></div>
                        </div>
                        <div>
                            <label class="form-label">Tabungan Bulanan</label>
                            <div class="relative"><span class="absolute left-3 top-1/2 -translate-y-1/2 text-cool-gray text-sm">Rp</span><input type="number" x-model="monthly" class="form-input pl-10" placeholder="500.000"></div>
                        </div>
                        <div>
                            <label class="form-label">Return Tahunan (%) <span class="text-xs text-cool-gray">Deposito ~5%, Reksa Dana ~8-12%</span></label>
                            <input type="number" x-model="rate" min="1" max="50" step="0.5" class="form-input">
                        </div>
                        <div>
                            <label class="form-label">Jangka Waktu (tahun)</label>
                            <input type="number" x-model="years" min="1" max="40" class="form-input">
                        </div>
                        <button @click="calculate()" class="btn-primary w-full justify-center">Hitung Investasi</button>
                    </div>
                </div>
                <div x-show="result" class="card p-8">
                    <h2 class="font-bold text-rich-black text-xl mb-4">📊 Proyeksi Investasi</h2>
                    <div class="space-y-3 mb-4">
                        <div class="flex justify-between p-3 bg-subtle-ash rounded-xl"><span class="text-sm text-cool-gray">Total Modal Disetor</span><span class="font-bold">Rp <span x-text="fmt(result?.total_contributions)"></span></span></div>
                        <div class="flex justify-between p-3 bg-subtle-ash rounded-xl"><span class="text-sm text-cool-gray">Total Keuntungan</span><span class="font-bold text-deep-fern-green">Rp <span x-text="fmt(result?.total_gain)"></span></span></div>
                        <div class="flex justify-between p-4 bg-mint-green-glow border border-leafy-green rounded-xl"><span class="font-semibold text-deep-fern-green">Nilai Akhir! 🎉</span><span class="text-xl font-bold text-deep-fern-green">Rp <span x-text="fmt(result?.final_balance)"></span></span></div>
                    </div>
                    <div class="chart-container"><canvas id="investChart"></canvas></div>
                </div>
            </div>
        </div>

        {{-- Tab: Anggaran --}}
        <div x-show="tab==='anggaran'" x-data="anggaranSim()">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="card p-8">
                    <h2 class="font-bold text-rich-black text-xl mb-2">💰 Simulasi Anggaran Bulanan</h2>
                    <p class="text-sm text-cool-gray mb-6">Metode 50/30/20: Kebutuhan, Keinginan, Tabungan</p>
                    <div>
                        <label class="form-label">Penghasilan Bulanan (Rp)</label>
                        <div class="relative"><span class="absolute left-3 top-1/2 -translate-y-1/2 text-cool-gray text-sm">Rp</span><input type="number" x-model="income" class="form-input pl-10" placeholder="5.000.000"></div>
                    </div>
                    <button @click="calculate()" class="btn-primary w-full justify-center mt-6">Hitung Anggaran</button>
                    <div x-show="result" class="mt-6 space-y-3">
                        <div class="flex justify-between p-3 bg-mint-green-glow rounded-xl"><span class="text-sm font-medium text-rich-black">🏠 Kebutuhan (50%)</span><span class="font-bold text-deep-fern-green">Rp <span x-text="fmt(result?.needs)"></span></span></div>
                        <div class="flex justify-between p-3 bg-melon-tint rounded-xl"><span class="text-sm font-medium text-rich-black">🎮 Keinginan (30%)</span><span class="font-bold text-terra-cotta">Rp <span x-text="fmt(result?.wants)"></span></span></div>
                        <div class="flex justify-between p-3 bg-sky-mist rounded-xl"><span class="text-sm font-medium text-rich-black">💎 Tabungan (20%)</span><span class="font-bold text-blue-700">Rp <span x-text="fmt(result?.savings)"></span></span></div>
                    </div>
                </div>
                <div x-show="result" class="card p-8">
                    <h2 class="font-bold text-rich-black text-xl mb-4">Rincian Anggaran</h2>
                    <div class="space-y-2">
                        <template x-for="item in (result?.breakdown || [])">
                            <div class="flex items-center justify-between p-3 rounded-xl hover:bg-subtle-ash">
                                <div class="flex-1">
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-rich-black font-medium" x-text="item.label"></span>
                                        <span class="text-cool-gray" x-text="item.pct + '%'"></span>
                                    </div>
                                    <div class="progress-bar"><div class="progress-fill" :style="'width:' + item.pct + '%'"></div></div>
                                </div>
                                <span class="ml-4 text-sm font-bold text-deep-fern-green w-24 text-right" x-text="'Rp ' + fmt(item.amount)"></span>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function pinjolSim() {
    return {
        principal: 1000000, dailyRate: 1, days: 30, result: null,
        async calculate() {
            const r = await fetch('{{ route("simulation.pinjol") }}', {
                method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
                body: JSON.stringify({principal:this.principal, daily_rate:this.dailyRate, days:this.days})
            });
            this.result = await r.json();
        },
        fmt(v) { return v ? v.toLocaleString('id-ID') : '0'; }
    }
}

function investasiSim() {
    return {
        principal: 1000000, monthly: 500000, rate: 8, years: 10, result: null, chart: null,
        async calculate() {
            const r = await fetch('{{ route("simulation.investment") }}', {
                method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
                body: JSON.stringify({principal:this.principal, monthly_contribution:this.monthly, annual_rate:this.rate, years:this.years})
            });
            this.result = await r.json();
            this.$nextTick(() => this.renderChart());
        },
        renderChart() {
            const ctx = document.getElementById('investChart');
            if (!ctx || !this.result) return;
            if (this.chart) this.chart.destroy();
            this.chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: this.result.yearly_data.map(d => 'Tahun ' + d.year),
                    datasets: [
                        { label: 'Nilai Investasi', data: this.result.yearly_data.map(d => d.balance), borderColor: '#0b7443', backgroundColor: 'rgba(11,116,67,0.1)', fill: true, tension: 0.4 },
                        { label: 'Modal Disetor', data: this.result.yearly_data.map(d => d.contrib), borderColor: '#5b616b', borderDash: [4,4], fill: false }
                    ]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'top' } }, scales: { y: { ticks: { callback: v => 'Rp ' + (v/1000000).toFixed(1) + 'jt' } } } }
            });
        },
        fmt(v) { return v ? v.toLocaleString('id-ID') : '0'; }
    }
}

function anggaranSim() {
    return {
        income: 5000000, result: null,
        async calculate() {
            const r = await fetch('{{ route("simulation.budget") }}', {
                method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
                body: JSON.stringify({income:this.income})
            });
            this.result = await r.json();
        },
        fmt(v) { return v ? v.toLocaleString('id-ID') : '0'; }
    }
}
</script>
@endpush
