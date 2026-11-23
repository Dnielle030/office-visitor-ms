@extends('layouts.app')
@section('title','Activity log')
@section('content')
<h1>Activity log</h1>
<p class="sub">Who registered, edited, checked out or exported what, and when.</p>
<div class="panel scroll"><table>
  <tr><th>When</th><th>User</th><th>Action</th><th>Details</th><th>IP address</th></tr>
  @forelse($logs as $l)
  <tr>
    <td style="white-space:nowrap">{{ $l->created_at->format('M d, Y h:i:s A') }}</td>
    <td>{{ $l->user?->name ?? 'Unknown' }}</td>
    <td><span class="tag">{{ $l->action }}</span></td>
    <td>{{ $l->description }}</td>
    <td>{{ $l->ip_address }}</td>
  </tr>
  @empty
  <tr><td colspan="5" class="empty">Nothing logged yet.</td></tr>
  @endforelse
</table>
<ul class="pagination">
  @if($logs->previousPageUrl())<li><a class="btn alt sm" href="{{ $logs->previousPageUrl() }}">Previous</a></li>@endif
  @if($logs->nextPageUrl())<li><a class="btn alt sm" href="{{ $logs->nextPageUrl() }}">Next</a></li>@endif
</ul>
</div>
@endsection
