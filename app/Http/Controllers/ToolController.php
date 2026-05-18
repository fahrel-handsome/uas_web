<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ToolController extends Controller
{
    public function savings(): View
    {
        return view('tools.savings');
    }

    public function investment(): View
    {
        return view('tools.investment');
    }

    public function budget(): View
    {
        return view('tools.budget');
    }

    public function mortgage(): View
    {
        return view('tools.mortgage');
    }
}
