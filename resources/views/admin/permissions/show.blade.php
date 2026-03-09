@extends('layouts.admin')

@section('title','Permission Details')

@section('content')

<div class="card">

<div class="card-header">
Permission Details
</div>

<div class="card-body">

<p><strong>Name:</strong> {{ $permission->name }}</p>

<p><strong>Slug:</strong> {{ $permission->slug }}</p>

</div>

</div>

@endsection
