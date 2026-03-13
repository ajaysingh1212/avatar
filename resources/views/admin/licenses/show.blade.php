@extends('layouts.admin')

@section('title','License Details')

@section('content')

<div class="card shadow">

<div class="card-header">

<h3 class="card-title">License Details</h3>

</div>

<div class="card-body">

<table class="table table-bordered">

<tr>
<th width="200">License Key</th>
<td>
<span class="badge badge-dark p-2">
{{ $license->license_key }}
</span>
</td>
</tr>

<tr>
<th>Product</th>
<td>{{ $license->product_name }}</td>
</tr>

<tr>
<th>Plan</th>
<td>{{ $license->plan_name }}</td>
</tr>

<tr>
<th>Status</th>
<td>{{ $license->status }}</td>
</tr>

<tr>
<th>Used</th>
<td>

@if($license->is_used) <span class="badge badge-warning">Used</span>
@else <span class="badge badge-success">Unused</span>
@endif

</td>
</tr>

<tr>
<th>Issued At</th>
<td>{{ $license->issued_at }}</td>
</tr>

<tr>
<th>Expires At</th>
<td>{{ $license->expires_at }}</td>
</tr>

<tr>
<th>User</th>
<td>{{ optional($license->user)->name }}</td>
</tr>

<tr>
<th>Notes</th>
<td>{{ $license->notes }}</td>
</tr>

</table>

</div>

</div>

@endsection
