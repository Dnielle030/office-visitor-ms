@extends('layouts.app')
@section('title','Dashboard')
@section('content')
<h1>Dashboard</h1>
<p class="sub">Signed in as {{ auth()->user()->name }} ({{ auth()->user()->role }}).</p>

<div class="stats">
  <div class="stat"><b>{{ $inside }}</b><span>Visitors in the office now</span></div>
  <div class="stat"><b>{{ $today }}</b><span>Visitors today</span></div>
  @if(auth()->user()->isAdmin())
  <div class="stat"><b>{{ $total }}</b><span>All visitor records</span></div>
  @endif
</div>

<div class="panel">
  <div class="row" style="justify-content:space-between;align-items:center">
    <h2 style="margin:0;font-size:18px">Latest arrivals</h2>
    <a class="btn" href="{{ route('visitors.create') }}">Register visitor</a>
  </div>
  <div class="scroll"><table>
    <tr><th>Visitor</th><th>Visiting</th><th>Time in</th><th>Status</th></tr>
    @forelse($recent as $v)
      <tr>
        <td>{{ $v->name }}</td><td>{{ $v->host }}</td>
        <td>{{ $v->time_in->format('M d, h:i A') }}</td>
        <td>@if($v->time_out)<span class="tag">Left {{ $v->time_out->format('h:i A') }}</span>@else<span class="tag in">Inside</span>@endif</td>
      </tr>
    @empty
      <tr><td colspan="4" class="empty">No visitors yet. Register the first one.</td></tr>
    @endforelse
  </table></div>
</div>
@endsection
