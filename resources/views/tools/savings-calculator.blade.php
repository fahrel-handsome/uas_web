@extends('layout')

@section('title', 'Kalkulator Tabungan - CerdasFin')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800 mb-6 inline-block">← Kembali ke Beranda</a>

        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <h1 class="text-4xl font-bold mb-4">Kalkulator Tabungan</h1>
            <p class="text-gray-600 text-lg">Proyeksikan pertumbuhan tabungan Anda dengan bunga majemuk</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Input Section -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold mb-6">Input Data Tabungan</h2>
                
                <div class="mb-6">
                    <label class="block text-sm font-semibold mb-2">Tabungan Awal (Rp)</label>
                    <input type="number" id="initialSavings" placeholder="10000000" value="10000000" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold mb-2">Setoran Bulanan (Rp)</label>
                    <input type="number" id="monthlyDeposit" placeholder="500000" value="500000" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold mb-2">Suku Bunga Tahunan (%)</label>
                    <input type="number" id="interestRate" placeholder="4.5" value="4.5" step="0.1" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold mb-2">Jangka Waktu (Tahun)</label>
                    <input type="number" id="period" placeholder="10" value="10" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>

                <button onclick="calculateSavings()" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-semibold">Hitung</button>
            </div>

            <!-- Result Section -->
            <div class="bg-gradient-to-br from-green-600 to-green-800 text-white rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold mb-6">Hasil Proyeksi</h2>
                
                <div class="space-y-6">
                    <div class="bg-white bg-opacity-10 rounded-lg p-4">
                        <p class="text-green-100 text-sm mb-1">Total Tabungan Akhir</p>
                        <p class="text-4xl font-bold" id="finalSavings">-</p>
                    </div>

                    <div class="bg-white bg-opacity-10 rounded-lg p-4">
                        <p class="text-green-100 text-sm mb-1">Total Setoran</p>
                        <p class="text-2xl font-bold" id="totalDeposits">-</p>
                    </div>

                    <div class="bg-white bg-opacity-10 rounded-lg p-4">
                        <p class="text-green-100 text-sm mb-1">Total Bunga Diterima</p>
                        <p class="text-2xl font-bold" id="totalInterest">-</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function calculateSavings() {
            const initial = parseFloat(document.getElementById('initialSavings').value);
            const monthly = parseFloat(document.getElementById('monthlyDeposit').value);
            const rate = parseFloat(document.getElementById('interestRate').value) / 100 / 12;
            const months = parseInt(document.getElementById('period').value) * 12;

            let balance = initial;
            const deposits = initial + (monthly * months);

            for (let i = 0; i < months; i++) {
                balance = balance * (1 + rate) + monthly;
            }

            const interest = balance - deposits;

            document.getElementById('finalSavings').textContent = 
                'Rp ' + balance.toLocaleString('id-ID', {maximumFractionDigits: 0});
            document.getElementById('totalDeposits').textContent = 
                'Rp ' + deposits.toLocaleString('id-ID', {maximumFractionDigits: 0});
            document.getElementById('totalInterest').textContent = 
                'Rp ' + interest.toLocaleString('id-ID', {maximumFractionDigits: 0});
        }

        calculateSavings();

        document.getElementById('initialSavings').addEventListener('input', calculateSavings);
        document.getElementById('monthlyDeposit').addEventListener('input', calculateSavings);
        document.getElementById('interestRate').addEventListener('input', calculateSavings);
        document.getElementById('period').addEventListener('input', calculateSavings);
    </script>
@endsection
