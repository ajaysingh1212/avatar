@extends('layouts.admin')

@section('title','User Details')

@section('content')

<div class="card">

<div class="card-header">

<h3>User Details</h3>

</div>

<div class="card-body">

<p><strong>Name:</strong> {{ $user->name }}</p>

<p><strong>Email:</strong> {{ $user->email }}</p>

<p>

<strong>Role:</strong>

{{ $user->roles->pluck('name')->implode(',') }}

</p>

</div>

</div>

@endsection
