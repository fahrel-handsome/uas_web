<?php

namespace App\Http\Controllers;

use App\Services\SimulationService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SimulationController extends Controller
{
    public function __construct(private SimulationService $simulationService) {}

    public function index(): View
    {
        return view('simulation.index');
    }

    public function pinjol(Request $request)
    {
        $request->validate([
            'principal' => 'required|numeric|min:100000',
            'daily_rate' => 'required|numeric|min:0.1|max:10',
            'days' => 'required|integer|min:7|max:365',
        ]);

        $result = $this->simulationService->calculatePinjolInterest(
            $request->principal,
            $request->daily_rate / 100,
            $request->days
        );

        return response()->json($result);
    }

    public function investment(Request $request)
    {
        $request->validate([
            'principal' => 'required|numeric|min:100000',
            'monthly_contribution' => 'required|numeric|min:0',
            'annual_rate' => 'required|numeric|min:0.1|max:50',
            'years' => 'required|integer|min:1|max:40',
        ]);

        $result = $this->simulationService->calculateInvestment(
            $request->principal,
            $request->monthly_contribution,
            $request->annual_rate / 100,
            $request->years
        );

        return response()->json($result);
    }

    public function budget(Request $request)
    {
        $request->validate([
            'income' => 'required|numeric|min:100000',
        ]);

        $result = $this->simulationService->calculateBudget($request->income);
        return response()->json($result);
    }
}
