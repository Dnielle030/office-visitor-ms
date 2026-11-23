<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        return view('logs.index', [
            'logs' => ActivityLog::with('user')->latest()->simplePaginate(25),
        ]);
    }
}
