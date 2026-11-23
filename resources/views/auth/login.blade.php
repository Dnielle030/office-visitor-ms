@extends('layouts.app')
@section('title','Log in')
@section('content')
<div style="max-width:400px;margin:60px auto">
  <h1>Office Visitor Management</h1>
  <p class="sub">Authorized office personnel only. Log in to continue.</p>
  <form class="panel" method="POST" action="{{ route('login') }}" autocomplete="off">
    @csrf
    <label for="email" style="margin-top:0">Email</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
    <label for="password">Password</label>
    <input id="password" type="password" name="password" required>
    <p><button class="btn" type="submit">Log in</button></p>
  </form>
</div>
@endsection
