@extends('layout')

@section('title', 'Perencana Anggaran - CerdasFin')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800 mb-6 inline-block">← Kembali ke Beranda</a>

        <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
            <h1 class="text-4xl font-bold mb-4">Perencana Anggaran</h1>
            <p class="text-gray-600 text-lg">Kelola pengeluaran Anda dengan metode 50/30/20</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Input Section -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold mb-6">Pendapatan & Pengeluaran</h2>
                
                <div class="mb-6">
                    <label class="block text-sm font-semibold mb-2">Pendapatan Bulanan (Rp)</label>
                    <input type="number" id="monthlyIncome" placeholder="5000000" value="5000000" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold mb-2">Kebutuhan (Sebutkan Rp)</label>
                    <input type="number" id="needs" placeholder="2000000" value="2000000" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold mb-2">Keinginan (Sebutkan Rp)</label>
                    <input type="number" id="wants" placeholder="1000000" value="1000000" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold mb-2">Tabungan & Investasi (Rp)</label>
                    <input type="number" id="savings" placeholder="1000000" value="1000000" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>

                <button onclick="calculateBudget()" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-semibold">Analisis Anggaran</button>
            </div>

            <!-- Result Section -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold mb-6">Analisis 50/30/20</h2>
                
                <div class="mb-6">
                    <div class="flex justify-between mb-2">
                        <span class="font-semibold">Kebutuhan (Target 50%)</span>
                        <span id="needsPercent" class="text-blue-600 font-bold">0%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-4">
                        <div class="bg-red-500 h-4 rounded-full" id="needsBar"></div>
                    </div>
                    <p class="text-sm text-gray-600 mt-1">Rp <span id="needsAmount">0</span></p>
                </div>

                <div class="mb-6">
                    <div class="flex justify-between mb-2">
                        <span class="font-semibold">Keinginan (Target 30%)</span>
                        <span id="wantsPercent" class="text-blue-600 font-bold">0%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-4">
                        <div class="bg-yellow-500 h-4 rounded-full" id="wantsBar"></div>
                    </div>
                    <p class="text-sm text-gray-600 mt-1">Rp <span id="wantsAmount">0</span></p>
                </div>

                <div class="mb-6">
                    <div class="flex justify-between mb-2">
                        <span class="font-semibold">Tabungan (Target 20%)</span>
                        <span id="savingsPercent" class="text-blue-600 font-bold">0%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-4">
                        <div class="bg-green-500 h-4 rounded-full" id="savingsBar"></div>
                    </div>
                    <p class="text-sm text-gray-600 mt-1">Rp <span id="savingsAmount">0</span></p>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mt-6">
                    <p class="text-sm text-blue-900"><strong>Total Pengeluaran:</strong> Rp <span id="totalSpent">0</span></p>
                    <p class="text-sm text-blue-900"><strong>Sisa/Deficit:</strong> Rp <span id="balance">0</span></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function calculateBudget() {
            const income = parseFloat(document.getElementById('monthlyIncome').value);
            const needs = parseFloat(document.getElementById('needs').value);
            const wants = parseFloat(document.getElementById('wants').value);
            const savings = parseFloat(document.getElementById('savings').value);

            const needsPercent = (needs / income) * 100;
            const wantsPercent = (wants / income) * 100;
            const savingsPercent = (savings / income) * 100;
            const total = needs + wants + savings;
            const balance = income - total;

            document.getElementById('needsPercent').textContent = needsPercent.toFixed(1) + '%';
            document.getElementById('wantsPercent').textContent = wantsPercent.toFixed(1) + '%';
            document.getElementById('savingsPercent').textContent = savingsPercent.toFixed(1) + '%';

            document.getElementById('needsBar').style.width = Math.min(needsPercent, 100) + '%';
            document.getElementById('wantsBar').style.width = Math.min(wantsPercent, 100) + '%';
            document.getElementById('savingsBar').style.width = Math.min(savingsPercent, 100) + '%';

            document.getElementById('needsAmount').textContent = needs.toLocaleString('id-ID', {maximumFractionDigits: 0});
            document.getElementById('wantsAmount').textContent = wants.toLocaleString('id-ID', {maximumFractionDigits: 0});
            document.getElementById('savingsAmount').textContent = savings.toLocaleString('id-ID', {maximumFractionDigits: 0});
            document.getElementById('totalSpent').textContent = total.toLocaleString('id-ID', {maximumFractionDigits: 0});
            document.getElementById('balance').textContent = balance.toLocaleString('id-ID', {maximumFractionDigits: 0});
        }

        calculateBudget();

        document.getElementById('monthlyIncome').addEventListener('input', calculateBudget);
        document.getElementById('needs').addEventListener('input', calculateBudget);
        document.getElementById('wants').addEventListener('input', calculateBudget);
        document.getElementById('savings').addEventListener('input', calculateBudget);
    </script>
@endsection
