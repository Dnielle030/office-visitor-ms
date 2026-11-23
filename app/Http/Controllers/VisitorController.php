<?php

namespace App\Http\Controllers;

use App\Http\Requests\VisitorRequest;
use App\Models\ActivityLog;
use App\Models\Visitor;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    /** Search by name or date. Eloquent binds all values (prepared statements). */
    public function index(Request $request)
    {
        $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'date' => ['nullable', 'date'],
        ]);

        $archived = $request->boolean('archived') && $request->user()->isAdmin();

        $query = Visitor::with('registrar')->latest('time_in');

        if ($archived) {
            $query->onlyTrashed();
        }
        if ($request->filled('q')) {
            $query->where('name', 'like', '%'.$request->q.'%');
        }
        if ($request->filled('date')) {
            $query->whereDate('time_in', $request->date);
        }

        return view('visitors.index', [
            'visitors' => $query->simplePaginate(15)->withQueryString(),
            'archived' => $archived,
        ]);
    }

    public function inside()
    {
        return view('visitors.inside', [
            'visitors' => Visitor::inside()->with('registrar')->orderBy('time_in')->get(),
        ]);
    }

    public function create()
    {
        return view('visitors.create');
    }

    public function store(VisitorRequest $request)
    {
        $visitor = Visitor::create($request->validated() + [
            'time_in' => now(),
            'registered_by' => $request->user()->id,
        ]);

        ActivityLog::record('visitor_registered', "Registered visitor #{$visitor->id} ({$visitor->name})");

        return redirect()->route('visitors.inside')
            ->with('status', "{$visitor->name} is checked in at ".$visitor->time_in->format('h:i A').'.');
    }

    public function checkout(Visitor $visitor)
    {
        if ($visitor->time_out) {
            return back()->withErrors(['visitor' => 'This visitor is already checked out.']);
        }

        $visitor->update(['time_out' => now(), 'checked_out_by' => auth()->id()]);
        ActivityLog::record('visitor_checkout', "Checked out visitor #{$visitor->id} ({$visitor->name})");

        return back()->with('status', "{$visitor->name} is checked out.");
    }

    // ---- Admin only ----

    public function edit(Visitor $visitor)
    {
        return view('visitors.edit', compact('visitor'));
    }

    public function update(VisitorRequest $request, Visitor $visitor)
    {
        $visitor->fill($request->validated());
        $fields = implode(', ', array_keys($visitor->getDirty()));
        $visitor->save();

        ActivityLog::record('visitor_edited', "Edited visitor #{$visitor->id}".($fields ? " (changed: {$fields})" : ' (no changes)'));

        return redirect()->route('visitors.index')->with('status', 'Visitor record updated.');
    }

    public function archive(Visitor $visitor)
    {
        if (! $visitor->time_out) {
            return back()->withErrors(['visitor' => 'Check the visitor out before archiving the record.']);
        }

        $visitor->delete();
        ActivityLog::record('visitor_archived', "Archived visitor #{$visitor->id} ({$visitor->name})");

        return back()->with('status', 'Record archived.');
    }

    public function restore(Visitor $visitor)
    {
        $visitor->restore();
        ActivityLog::record('visitor_restored', "Restored visitor #{$visitor->id} ({$visitor->name})");

        return back()->with('status', 'Record restored.');
    }
}
