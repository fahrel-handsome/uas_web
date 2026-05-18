@extends('layout')

@section('title', 'Kalkulator Hipotik - CerdasFin')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800 mb-6 inline-block">← Kembali ke Beranda</a>

        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <h1 class="text-4xl font-bold mb-4">Kalkulator Hipotik</h1>
            <p class="text-gray-600 text-lg">Hitung cicilan bulanan dan total bunga untuk pinjaman rumah Anda</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Input Section -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold mb-6">Input Data Pinjaman</h2>
                
                <div class="mb-6">
                    <label class="block text-sm font-semibold mb-2">Jumlah Pinjaman (Rp)</label>
                    <input type="number" id="principal" placeholder="500000000" value="500000000" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold mb-2">Suku Bunga Tahunan (%)</label>
                    <input type="number" id="rate" placeholder="5.5" value="5.5" step="0.1" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold mb-2">Jangka Waktu (Tahun)</label>
                    <input type="number" id="years" placeholder="20" value="20" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>

                <button onclick="calculateMortgage()" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-semibold">Hitung</button>
            </div>

            <!-- Result Section -->
            <div class="bg-gradient-to-br from-blue-600 to-blue-800 text-white rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold mb-6">Hasil Perhitungan</h2>
                
                <div class="space-y-6">
                    <div class="bg-white bg-opacity-10 rounded-lg p-4">
                        <p class="text-blue-100 text-sm mb-1">Cicilan Bulanan</p>
                        <p class="text-4xl font-bold" id="monthlyPayment">-</p>
                    </div>

                    <div class="bg-white bg-opacity-10 rounded-lg p-4">
                        <p class="text-blue-100 text-sm mb-1">Total Bunga</p>
                        <p class="text-2xl font-bold" id="totalInterest">-</p>
                    </div>

                    <div class="bg-white bg-opacity-10 rounded-lg p-4">
                        <p class="text-blue-100 text-sm mb-1">Total Pembayaran</p>
                        <p class="text-2xl font-bold" id="totalPayment">-</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function calculateMortgage() {
            const principal = parseFloat(document.getElementById('principal').value);
            const annualRate = parseFloat(document.getElementById('rate').value);
            const years = parseInt(document.getElementById('years').value);

            const monthlyRate = annualRate / 12 / 100;
            const numberOfPayments = years * 12;

            const monthlyPayment = principal * 
                (monthlyRate * Math.pow(1 + monthlyRate, numberOfPayments)) / 
                (Math.pow(1 + monthlyRate, numberOfPayments) - 1);

            const totalPayment = monthlyPayment * numberOfPayments;
            const totalInterest = totalPayment - principal;

            document.getElementById('monthlyPayment').textContent = 
                'Rp ' + monthlyPayment.toLocaleString('id-ID', {maximumFractionDigits: 0});
            document.getElementById('totalInterest').textContent = 
                'Rp ' + totalInterest.toLocaleString('id-ID', {maximumFractionDigits: 0});
            document.getElementById('totalPayment').textContent = 
                'Rp ' + totalPayment.toLocaleString('id-ID', {maximumFractionDigits: 0});
        }

        // Calculate on page load
        calculateMortgage();

        // Add event listeners
        document.getElementById('principal').addEventListener('input', calculateMortgage);
        document.getElementById('rate').addEventListener('input', calculateMortgage);
        document.getElementById('years').addEventListener('input', calculateMortgage);
    </script>
@endsection
