@extends('layouts.app')
@section('title','Staff accounts')
@section('content')
<h1>Staff accounts</h1>
<p class="sub">Create receptionist and administrator accounts, or deactivate access.</p>

<div class="panel scroll"><table>
  <tr><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th></th></tr>
  @foreach($users as $u)
  <tr>
    <td>{{ $u->name }}</td><td>{{ $u->email }}</td><td>{{ $u->role }}</td>
    <td><span class="tag {{ $u->is_active ? 'in' : 'off' }}">{{ $u->is_active ? 'Active' : 'Deactivated' }}</span></td>
    <td>@if($u->id !== auth()->id())
      <form method="POST" action="{{ route('staff.toggle', $u) }}">@csrf @method('PATCH')
        <button class="btn alt sm" type="submit">{{ $u->is_active ? 'Deactivate' : 'Activate' }}</button></form>
    @endif</td>
  </tr>
  @endforeach
</table></div>

<form class="panel" method="POST" action="{{ route('staff.store') }}" autocomplete="off">
  @csrf
  <h2 style="margin:0;font-size:18px">Add staff account</h2>
  <div class="grid2">
    <div><label for="name">Full name</label><input id="name" name="name" value="{{ old('name') }}" required></div>
    <div><label for="email">Email</label><input id="email" type="email" name="email" value="{{ old('email') }}" required></div>
    <div><label for="role">Role</label>
      <select id="role" name="role"><option value="receptionist">Receptionist</option><option value="admin" @selected(old('role')==='admin')>Administrator</option></select></div>
    <div></div>
    <div><label for="password">Password</label><input id="password" type="password" name="password" required></div>
    <div><label for="password_confirmation">Confirm password</label><input id="password_confirmation" type="password" name="password_confirmation" required></div>
  </div>
  <p class="sub" style="margin:6px 0">At least 8 characters with upper and lower case letters and a number.</p>
  <button class="btn" type="submit">Create account</button>
</form>
@endsection
