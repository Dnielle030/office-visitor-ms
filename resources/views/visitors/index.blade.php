@extends('layouts.app')
@section('title','Visitor records')
@section('content')
<h1>{{ $archived ? 'Archived records' : 'Visitor records' }}</h1>
<p class="sub">Search by visitor name or by date of arrival.</p>

<form class="panel" method="GET" action="{{ route('visitors.index') }}">
  <div class="row">
    <div><label for="q" style="margin-top:0">Name</label><input id="q" name="q" value="{{ request('q') }}"></div>
    <div><label for="date" style="margin-top:0">Date</label><input id="date" type="date" name="date" value="{{ request('date') }}"></div>
    @if(auth()->user()->isAdmin())
    <div style="flex:0 0 auto"><label style="margin-top:0;font-weight:400">
      <input type="checkbox" name="archived" value="1" style="width:auto" @checked($archived)> Show archived</label></div>
    @endif
    <div style="flex:0 0 auto"><button class="btn" type="submit">Search</button></div>
  </div>
</form>

<div class="panel scroll"><table>
  <tr><th>Visitor</th><th>Contact</th><th>Visiting</th><th>Purpose</th><th>Time in</th><th>Time out</th><th>Registered by</th>@if(auth()->user()->isAdmin())<th></th>@endif</tr>
  @forelse($visitors as $v)
  <tr>
    <td>{{ $v->name }}</td>
    <td>{{ $v->contactFor(auth()->user()) }}</td>
    <td>{{ $v->host }}</td>
    <td>{{ $v->purpose }}</td>
    <td>{{ $v->time_in->format('M d, h:i A') }}</td>
    <td>{{ $v->time_out?->format('M d, h:i A') ?? 'Inside' }}</td>
    <td>{{ $v->registrar?->name }}</td>
    @if(auth()->user()->isAdmin())
    <td style="white-space:nowrap">
      @if($archived)
        <form class="inline" method="POST" action="{{ route('visitors.restore', $v) }}">@csrf @method('PATCH')
          <button class="btn alt sm" type="submit">Restore</button></form>
      @else
        <a class="btn alt sm" href="{{ route('visitors.edit', $v) }}">Edit</a>
        @if($v->time_out)
        <form class="inline" method="POST" action="{{ route('visitors.archive', $v) }}"
              onsubmit="return confirm('Archive this record?')">@csrf @method('DELETE')
          <button class="btn alt sm" type="submit">Archive</button></form>
        @endif
      @endif
    </td>
    @endif
  </tr>
  @empty
  <tr><td colspan="8" class="empty">No records match your search.</td></tr>
  @endforelse
</table>
<ul class="pagination">
  @if($visitors->previousPageUrl())<li><a class="btn alt sm" href="{{ $visitors->previousPageUrl() }}">Previous</a></li>@endif
  @if($visitors->nextPageUrl())<li><a class="btn alt sm" href="{{ $visitors->nextPageUrl() }}">Next</a></li>@endif
</ul>
</div>
@endsection
