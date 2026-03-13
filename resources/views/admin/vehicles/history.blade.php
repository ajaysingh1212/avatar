@extends('layouts.admin')

@section('title','Vehicle History')

@section('content')

<div class="card">

<div class="card-header">

Vehicle History

</div>

<div class="card-body">

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>IMEI</th>
<th>Latitude</th>
<th>Longitude</th>
<th>Speed</th>
<th>Ignition</th>
<th>Time</th>

</tr>

</thead>

<tbody>

@foreach($history as $h)

<tr>

<td>{{ $h->imei }}</td>

<td>{{ $h->latitude }}</td>

<td>{{ $h->longitude }}</td>

<td>{{ $h->speed }} km/h</td>

<td>

@if($h->ignition)

<span class="badge badge-success">ON</span>

@else

<span class="badge badge-danger">OFF</span>

@endif

</td>

<td>{{ $h->tracked_at }}</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

@endsection
