@extends('layouts.admin')

@section('title','Role Details')

@section('content')

<div class="card">

	<div class="card-header">
		Role Details
	</div>

	<div class="card-body">

		<p><strong>Name:</strong> {{ $role->name }}</p>

		<p><strong>Slug:</strong> {{ $role->slug }}</p>

		<h5>Permissions</h5>

		@foreach($role->permissions as $permission)

		<span class="badge badge-success">

			{{ $permission->name }}

		</span>

		@endforeach

	</div>

</div>

@endsection
