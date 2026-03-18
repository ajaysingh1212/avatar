@extends('layouts.admin')

@section('title','Transfer Details')

@section('content')

<div class="card shadow-lg">

<div class="card-header">
<h3>Transfer Details #{{ $transfer->id }}</h3>
</div>

<div class="card-body">

<div class="row mb-3">

<div class="col-md-4">
<strong>Reseller:</strong>
{{ $transfer->user->name }}
</div>

<div class="col-md-4">
<strong>Total Licenses:</strong>
{{ $transfer->total_licenses }}
</div>

<div class="col-md-4">
<strong>Date:</strong>
{{ $transfer->created_at->format('d M Y') }}
</div>

</div>

<hr>

<h5>Transferred Licenses</h5>

<table class="table table-bordered">

<thead>

<tr>

<th>License</th>
<th>Product</th>
<th>Plan</th>
<th>Devices</th>
<th>Validity</th>
<th>Issued</th>
<th>Expiry</th>

</tr>

</thead>

<tbody>

@foreach($transfer->items as $item)

<tr>

<td>{{ $item->license->license_key }}</td>
<td>{{ $item->license->product_name }}</td>
<td>{{ $item->license->plan_name }}</td>
<td>{{ $item->license->max_devices }}</td>
<td>{{ $item->license->validity_days }}</td>
<td>{{ $item->license->issued_at }}</td>
<td>{{ $item->license->expires_at }}</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

@endsection
