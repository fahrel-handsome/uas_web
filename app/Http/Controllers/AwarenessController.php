<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class AwarenessController extends Controller
{
    public function index(): View
    {
        return view('awareness.index');
    }
}
