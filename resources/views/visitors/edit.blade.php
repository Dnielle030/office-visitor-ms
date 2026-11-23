@extends('layouts.app')
@section('title','Edit visitor')
@section('content')
<h1>Edit visitor record #{{ $visitor->id }}</h1>
<p class="sub">Time in and time out cannot be changed. Every edit is written to the activity log.</p>
<form class="panel" method="POST" action="{{ route('visitors.update', $visitor) }}">
  @csrf @method('PUT')
  @include('visitors._form')
  <p><button class="btn" type="submit">Save changes</button>
     <a class="btn alt" href="{{ route('visitors.index') }}">Cancel</a></p>
</form>
@endsection
