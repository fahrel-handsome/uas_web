@extends('layout')

@section('title', 'Kalkulator Investasi - CerdasFin')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800 mb-6 inline-block">← Kembali ke Beranda</a>

        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <h1 class="text-4xl font-bold mb-4">Kalkulator Investasi</h1>
            <p class="text-gray-600 text-lg">Proyeksikan pertumbuhan investasi Anda dengan perhitungan bunga majemuk</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Input Section -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold mb-6">Input Data Investasi</h2>
                
                <div class="mb-6">
                    <label class="block text-sm font-semibold mb-2">Investasi Awal (Rp)</label>
                    <input type="number" id="investmentAmount" placeholder="50000000" value="50000000" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold mb-2">Investasi Berkala (Rp)</label>
                    <input type="number" id="regularInvestment" placeholder="1000000" value="1000000" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold mb-2">Return Tahunan (%)</label>
                    <input type="number" id="returnRate" placeholder="8" value="8" step="0.1" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold mb-2">Jangka Waktu (Tahun)</label>
                    <input type="number" id="investmentYears" placeholder="15" value="15" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>

                <button onclick="calculateInvestment()" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-semibold">Hitung</button>
            </div>

            <!-- Result Section -->
            <div class="bg-gradient-to-br from-purple-600 to-purple-800 text-white rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold mb-6">Hasil Investasi</h2>
                
                <div class="space-y-6">
                    <div class="bg-white bg-opacity-10 rounded-lg p-4">
                        <p class="text-purple-100 text-sm mb-1">Total Nilai Investasi</p>
                        <p class="text-4xl font-bold" id="finalValue">-</p>
                    </div>

                    <div class="bg-white bg-opacity-10 rounded-lg p-4">
                        <p class="text-purple-100 text-sm mb-1">Total Modal</p>
                        <p class="text-2xl font-bold" id="totalCapital">-</p>
                    </div>

                    <div class="bg-white bg-opacity-10 rounded-lg p-4">
                        <p class="text-purple-100 text-sm mb-1">Total Keuntungan</p>
                        <p class="text-2xl font-bold" id="totalProfit">-</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function calculateInvestment() {
            const initial = parseFloat(document.getElementById('investmentAmount').value);
            const regular = parseFloat(document.getElementById('regularInvestment').value);
            const rate = parseFloat(document.getElementById('returnRate').value) / 100 / 12;
            const months = parseInt(document.getElementById('investmentYears').value) * 12;

            let value = initial;
            let totalCapital = initial;

            for (let i = 0; i < months; i++) {
                value = value * (1 + rate) + regular;
                totalCapital += regular;
            }

            const profit = value - totalCapital;

            document.getElementById('finalValue').textContent = 
                'Rp ' + value.toLocaleString('id-ID', {maximumFractionDigits: 0});
            document.getElementById('totalCapital').textContent = 
                'Rp ' + totalCapital.toLocaleString('id-ID', {maximumFractionDigits: 0});
            document.getElementById('totalProfit').textContent = 
                'Rp ' + profit.toLocaleString('id-ID', {maximumFractionDigits: 0});
        }

        calculateInvestment();

        document.getElementById('investmentAmount').addEventListener('input', calculateInvestment);
        document.getElementById('regularInvestment').addEventListener('input', calculateInvestment);
        document.getElementById('returnRate').addEventListener('input', calculateInvestment);
        document.getElementById('investmentYears').addEventListener('input', calculateInvestment);
    </script>
@endsection
