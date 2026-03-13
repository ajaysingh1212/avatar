@extends('layouts.admin')

@section('title','Vehicle Alerts')

@section('content')

<div class="card">

<div class="card-header">

Vehicle Alerts

</div>

<div class="card-body">

<table class="table table-bordered">

<thead>

<tr>

<th>Vehicle</th>
<th>Alert Type</th>
<th>Description</th>
<th>Time</th>

</tr>

</thead>

<tbody>

@foreach($alerts as $a)

<tr>

<td>{{ $a->imei }}</td>

<td>{{ $a->type }}</td>

<td>{{ $a->message }}</td>

<td>{{ $a->created_at }}</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

@endsection
