@extends('layouts.app')
@section('title','In the office')
@section('content')
<h1>Visitors in the office</h1>
<p class="sub">{{ $visitors->count() }} currently checked in.</p>
<div class="panel scroll"><table>
  <tr><th>Visitor</th><th>Contact</th><th>Visiting</th><th>Purpose</th><th>Time in</th><th></th></tr>
  @forelse($visitors as $v)
  <tr>
    <td>{{ $v->name }}</td>
    <td>{{ $v->contactFor(auth()->user()) }}</td>
    <td>{{ $v->host }}</td>
    <td>{{ $v->purpose }}</td>
    <td>{{ $v->time_in->format('h:i A') }}</td>
    <td>
      <form method="POST" action="{{ route('visitors.checkout', $v) }}">@csrf @method('PATCH')
        <button class="btn sm" type="submit">Check out</button>
      </form>
    </td>
  </tr>
  @empty
  <tr><td colspan="6" class="empty">Nobody is checked in right now.</td></tr>
  @endforelse
</table></div>
@endsection
