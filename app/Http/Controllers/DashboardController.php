<?php

namespace App\Http\Controllers;

use App\Models\Visitor;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'total' => Visitor::withTrashed()->count(),
            'inside' => Visitor::inside()->count(),
            'today' => Visitor::whereDate('time_in', today())->count(),
            'recent' => Visitor::with('registrar')->latest('time_in')->limit(8)->get(),
        ]);
    }
}
