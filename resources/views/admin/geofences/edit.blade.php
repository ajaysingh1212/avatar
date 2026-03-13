@extends('layouts.admin')

@section('title','Edit Geofence')

@section('content')

<div class="card">

<div class="card-header">

Edit Geofence

</div>

<form method="POST" action="{{ route('admin.geofences.update',$geofence->id) }}">

@csrf
@method('PUT')

<div class="card-body">

<label>Name</label>

<input type="text" name="name" value="{{ $geofence->name }}" class="form-control">

<br>

<label>Latitude</label>

<input type="text" name="lat" value="{{ $geofence->lat }}" class="form-control">

<br>

<label>Longitude</label>

<input type="text" name="lng" value="{{ $geofence->lng }}" class="form-control">

<br>

<label>Radius</label>

<input type="number" name="radius" value="{{ $geofence->radius }}" class="form-control">

</div>

<div class="card-footer">

<button class="btn btn-success">

Update Geofence

</button>

</div>

</form>

</div>

@endsection
