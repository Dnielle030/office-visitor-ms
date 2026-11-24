@extends('layouts.app')
@section('title','Log in')
@section('content')
<div style="max-width:430px;margin:48px auto">
  <div style="text-align:center;margin-bottom:18px">
    <img src="{{ asset('cvsu-logo.png') }}" alt="CvSU logo" style="width:110px;height:110px;object-fit:contain;filter:drop-shadow(0 8px 12px rgba(9,27,51,.12))">
  </div>
  <h1 style="text-align:center;color:#091b33">CvSU Visitor Management</h1>
  <p class="sub" style="text-align:center">Authorized office personnel only. Log in to continue.</p>
  <form class="panel" method="POST" action="{{ route('login') }}" autocomplete="off" style="padding:26px">
    @csrf
    <label for="email" style="margin-top:0">Email</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
    <label for="password">Password</label>
    <input id="password" type="password" name="password" required>
    <p><button class="btn" type="submit">Log in</button></p>
  </form>
</div>
@endsection
