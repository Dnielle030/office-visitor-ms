@extends('layouts.app')
@section('title','Register visitor')
@section('content')
<h1>Register visitor</h1>
<p class="sub">Time in is recorded automatically when you save.</p>
<form class="panel" method="POST" action="{{ route('visitors.store') }}">
  @csrf
  @include('visitors._form')
  <p><button class="btn" type="submit">Check in visitor</button></p>
</form>
@endsection
