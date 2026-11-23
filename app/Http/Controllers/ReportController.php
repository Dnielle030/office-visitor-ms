<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->validate([
            'period' => ['nullable', 'in:daily,weekly,monthly'],
            'date' => ['nullable', 'date'],
        ]);

        $period = $data['period'] ?? 'daily';
        $date = Carbon::parse($data['date'] ?? today());

        [$from, $to] = match ($period) {
            'weekly' => [$date->copy()->startOfWeek(), $date->copy()->endOfWeek()],
            'monthly' => [$date->copy()->startOfMonth(), $date->copy()->endOfMonth()],
            default => [$date->copy()->startOfDay(), $date->copy()->endOfDay()],
        };

        $visitors = Visitor::withTrashed()->with(['registrar', 'checkedOutBy'])
            ->whereBetween('time_in', [$from, $to])
            ->orderBy('time_in')
            ->get();

        if ($request->query('export') === 'csv') {
            return $this->csv($visitors, $period, $from, $to);
        }

        return view('reports.index', compact('visitors', 'period', 'from', 'to', 'date'));
    }

    private function csv($visitors, string $period, Carbon $from, Carbon $to)
    {
        ActivityLog::record('report_exported', "Exported {$period} report ({$from->toDateString()} to {$to->toDateString()})");

        // Prevent CSV/formula injection when opened in Excel
        $safe = fn ($v) => is_string($v) && preg_match('/^[=+\-@\t\r]/', $v) ? "'".$v : $v;

        return response()->streamDownload(function () use ($visitors, $safe) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Name', 'Contact', 'Purpose', 'Visiting', 'Time in', 'Time out', 'Registered by']);
            foreach ($visitors as $v) {
                fputcsv($out, array_map($safe, [
                    $v->name, $v->contact_number, $v->purpose, $v->host,
                    $v->time_in->format('Y-m-d H:i'), $v->time_out?->format('Y-m-d H:i'),
                    $v->registrar?->name,
                ]));
            }
            fclose($out);
        }, "visitors-{$period}-{$from->toDateString()}.csv", ['Content-Type' => 'text/csv']);
    }
}
