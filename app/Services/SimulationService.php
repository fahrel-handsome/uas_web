<?php

namespace App\Services;

class SimulationService
{
    /**
     * Hitung bunga majemuk pinjol ilegal.
     */
    public function calculatePinjolInterest(float $principal, float $dailyRate, int $days): array
    {
        $schedule = [];
        $amount = $principal;

        for ($day = 1; $day <= $days; $day++) {
            $interest = $amount * $dailyRate;
            $amount += $interest;
            if ($day % 7 === 0 || $day === $days) {
                $schedule[] = [
                    'day'      => $day,
                    'interest' => round($interest),
                    'total'    => round($amount),
                ];
            }
        }

        return [
            'principal'        => $principal,
            'daily_rate_pct'   => $dailyRate * 100,
            'days'             => $days,
            'total_debt'       => round($amount),
            'total_interest'   => round($amount - $principal),
            'interest_ratio'   => round(($amount - $principal) / $principal * 100, 1),
            'schedule'         => $schedule,
        ];
    }

    /**
     * Hitung investasi aman (compound interest bulanan).
     */
    public function calculateInvestment(float $principal, float $monthlyContribution, float $annualRate, int $years): array
    {
        $monthlyRate = $annualRate / 12;
        $months = $years * 12;
        $balance = $principal;
        $totalContributions = $principal;
        $yearlyData = [];

        for ($m = 1; $m <= $months; $m++) {
            $balance = $balance * (1 + $monthlyRate) + $monthlyContribution;
            $totalContributions += $monthlyContribution;

            if ($m % 12 === 0) {
                $yearlyData[] = [
                    'year'    => $m / 12,
                    'balance' => round($balance),
                    'contrib' => round($totalContributions),
                    'gain'    => round($balance - $totalContributions),
                ];
            }
        }

        return [
            'principal'            => $principal,
            'monthly_contribution' => $monthlyContribution,
            'annual_rate_pct'      => $annualRate * 100,
            'years'                => $years,
            'final_balance'        => round($balance),
            'total_contributions'  => round($totalContributions),
            'total_gain'           => round($balance - $totalContributions),
            'yearly_data'          => $yearlyData,
        ];
    }

    /**
     * Hitung anggaran bulanan metode 50/30/20.
     */
    public function calculateBudget(float $income): array
    {
        return [
            'income'   => $income,
            'needs'    => round($income * 0.50),    // 50% kebutuhan
            'wants'    => round($income * 0.30),    // 30% keinginan
            'savings'  => round($income * 0.20),    // 20% tabungan
            'breakdown' => [
                ['label' => 'Makanan & Minuman',    'pct' => 15, 'amount' => round($income * 0.15)],
                ['label' => 'Tempat Tinggal',       'pct' => 20, 'amount' => round($income * 0.20)],
                ['label' => 'Transportasi',         'pct' => 10, 'amount' => round($income * 0.10)],
                ['label' => 'Hiburan & Hobi',       'pct' => 15, 'amount' => round($income * 0.15)],
                ['label' => 'Pakaian & Lainnya',    'pct' => 15, 'amount' => round($income * 0.15)],
                ['label' => 'Tabungan',             'pct' => 10, 'amount' => round($income * 0.10)],
                ['label' => 'Investasi',            'pct' => 10, 'amount' => round($income * 0.10)],
                ['label' => 'Dana Darurat',         'pct' =>  5, 'amount' => round($income * 0.05)],
            ],
        ];
    }
}
