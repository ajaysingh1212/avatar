@extends('layouts.admin')

@section('title','Geofences')

@section('content')

<div class="card">

<div class="card-header">

Geofence List

<a href="{{ route('admin.geofences.create') }}" class="btn btn-primary btn-sm float-right">

Create Geofence

</a>

</div>

<div class="card-body">

<table class="table table-bordered">

<thead>

<tr>

<th>ID</th>
<th>Name</th>
<th>Latitude</th>
<th>Longitude</th>
<th>Radius</th>
<th>Action</th>

</tr>

</thead>

<tbody>

@foreach($geofences as $g)

<tr>

<td>{{ $g->id }}</td>

<td>{{ $g->name }}</td>

<td>{{ $g->lat }}</td>

<td>{{ $g->lng }}</td>

<td>{{ $g->radius }} m</td>

<td>

<a href="{{ route('admin.geofences.edit',$g->id) }}" class="btn btn-warning btn-sm">

Edit

</a>

<form method="POST" action="{{ route('admin.geofences.destroy',$g->id) }}" style="display:inline">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm">

Delete

</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

@endsection
