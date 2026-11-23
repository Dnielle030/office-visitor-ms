@extends('layouts.app')
@section('title','Reports')
@section('content')
<h1>Visitor report</h1>
<p class="sub">{{ $from->format('M d, Y') }}@if($period !== 'daily') to {{ $to->format('M d, Y') }}@endif · {{ $visitors->count() }} visitors</p>

<form class="panel" method="GET" action="{{ route('reports.index') }}">
  <div class="row">
    <div><label for="period" style="margin-top:0">Period</label>
      <select id="period" name="period">
        @foreach(['daily'=>'Daily','weekly'=>'Weekly','monthly'=>'Monthly'] as $k=>$label)
          <option value="{{ $k }}" @selected($period===$k)>{{ $label }}</option>
        @endforeach
      </select></div>
    <div><label for="date" style="margin-top:0">Date within period</label>
      <input id="date" type="date" name="date" value="{{ $date->toDateString() }}"></div>
    <div style="flex:0 0 auto"><button class="btn" type="submit">Show report</button></div>
    <div style="flex:0 0 auto"><a class="btn alt" href="{{ route('reports.index', ['period'=>$period,'date'=>$date->toDateString(),'export'=>'csv']) }}">Download CSV</a></div>
  </div>
</form>

<div class="panel scroll"><table>
  <tr><th>Visitor</th><th>Contact</th><th>Visiting</th><th>Purpose</th><th>Time in</th><th>Time out</th><th>Registered by</th></tr>
  @forelse($visitors as $v)
  <tr>
    <td>{{ $v->name }}</td><td>{{ $v->contact_number }}</td><td>{{ $v->host }}</td><td>{{ $v->purpose }}</td>
    <td>{{ $v->time_in->format('M d, h:i A') }}</td>
    <td>{{ $v->time_out?->format('M d, h:i A') ?? 'Inside' }}</td>
    <td>{{ $v->registrar?->name }}</td>
  </tr>
  @empty
  <tr><td colspan="7" class="empty">No visitors in this period.</td></tr>
  @endforelse
</table></div>
@endsection
