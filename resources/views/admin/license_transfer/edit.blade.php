@extends('layouts.admin')

@section('title','Edit Stock Transfer')

@section('content')

<div class="card shadow-lg">

<div class="card-header">
<h3>Edit Stock Transfer</h3>
</div>

<div class="card-body">

<form method="POST" action="{{ route('admin.license-transfer.update',$transfer->id) }}">
@csrf
@method('PUT')

<div class="row">

<div class="col-md-4">
<label>Transfer Date</label>
<input type="date" class="form-control"
value="{{ $transfer->created_at->format('Y-m-d') }}" readonly>
</div>

<div class="col-md-4">
<label>Reseller</label>

<select name="user_id" class="form-control">

@foreach($users as $user)

<option value="{{ $user->id }}"
{{ $transfer->to_user_id==$user->id?'selected':'' }}>

{{ $user->name }} ({{ $user->email }})

</option>

@endforeach

</select>

</div>

<div class="col-md-4">
<label>Total Licenses</label>
<input type="text" class="form-control"
value="{{ $transfer->total_licenses }}" readonly>
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
<td>{{ $item->license->expires_at }}</td>

</tr>

@endforeach

</tbody>

</table>

<button class="btn btn-primary mt-3">
Update Transfer
</button>

</form>

</div>
</div>

@endsection
