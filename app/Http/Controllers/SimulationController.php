<?php

namespace App\Http\Controllers;

use App\Services\SimulationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SimulationController extends Controller
{
    public function __construct(
        private readonly SimulationService $simulationService
    ) {}

    public function index(): View
    {
        return view('simulation.index');
    }

    /**
     * POST /simulation/pinjol
     * Hitung bunga majemuk harian pinjol ilegal.
     */
    public function pinjol(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'principal'  => 'required|numeric|min:100000|max:1000000000',
            'daily_rate' => 'required|numeric|min:0.01|max:10',
            'days'       => 'required|integer|min:1|max:365',
        ]);

        $result = $this->simulationService->calculatePinjolInterest(
            principal: (float) $validated['principal'],
            dailyRate: (float) $validated['daily_rate'] / 100, // convert % to decimal
            days:      (int) $validated['days']
        );

        return response()->json($result);
    }

    /**
     * POST /simulation/investment
     * Hitung investasi dengan bunga majemuk tahunan.
     */
    public function investment(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'principal'            => 'required|numeric|min:0|max:10000000000',
            'monthly_contribution' => 'required|numeric|min:0|max:100000000',
            'annual_rate'          => 'required|numeric|min:0.1|max:50',
            'years'                => 'required|integer|min:1|max:50',
        ]);

        $result = $this->simulationService->calculateInvestment(
            principal:           (float) $validated['principal'],
            monthlyContribution: (float) $validated['monthly_contribution'],
            annualRate:          (float) $validated['annual_rate'] / 100, // convert % to decimal
            years:               (int) $validated['years']
        );

        return response()->json($result);
    }

    /**
     * POST /simulation/budget
     * Hitung anggaran bulanan dengan metode 50/30/20.
     */
    public function budget(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'income' => 'required|numeric|min:500000|max:100000000000',
        ]);

        $result = $this->simulationService->calculateBudget(
            income: (float) $validated['income']
        );

        return response()->json($result);
    }
}
