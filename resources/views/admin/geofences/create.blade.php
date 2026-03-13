@extends('layouts.admin')

@section('title','Create Geofence')

@section('content')

<div class="card">

<div class="card-header">

Create Geofence

</div>

<form method="POST" action="{{ route('admin.geofences.store') }}">

@csrf

<div class="card-body">

<label>Name</label>

<input type="text" name="name" class="form-control">

<br>

<label>Latitude</label>

<input type="text" name="lat" class="form-control">

<br>

<label>Longitude</label>

<input type="text" name="lng" class="form-control">

<br>

<label>Radius (meters)</label>

<input type="number" name="radius" class="form-control">

</div>

<div class="card-footer">

<button class="btn btn-success">

Save Geofence

</button>

</div>

</form>

</div>

@endsection
