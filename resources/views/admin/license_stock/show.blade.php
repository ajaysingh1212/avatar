@extends('layouts.admin')

@section('title','License Details')

@section('content')

<div class="container-fluid">

<div class="row">

<div class="col-12">

<div class="card shadow-lg border-0">

<div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">

<h3 class="mb-0">
<i class="fas fa-key mr-2"></i> License Details
</h3>

<span class="badge badge-light p-2">
License ID : {{ $stock->id }}
</span>

</div>

<div class="card-body">

<div class="row">

{{-- LICENSE INFORMATION --}}

<div class="col-md-7">

<div class="card border-0 shadow-sm mb-4">

<div class="card-header bg-primary text-white">
<strong>License Information</strong>
</div>

<div class="card-body">

<table class="table table-striped">

<tr>
<th width="200">License Key</th>
<td>
<span class="badge badge-dark p-2">
{{ $stock->license_key }}
</span>
</td>
</tr>

<tr>
<th>Product</th>
<td>{{ $stock->product_name }}</td>
</tr>

<tr>
<th>Plan</th>
<td>{{ $stock->plan_name }}</td>
</tr>

<tr>
<th>Max Devices</th>
<td>{{ $stock->max_devices }}</td>
</tr>

<tr>
<th>Validity (Days)</th>
<td>{{ $stock->validity_days }}</td>
</tr>

<tr>
<th>Status</th>
<td>
@if($stock->status=='active')
<span class="badge badge-success">Active</span>
@elseif($stock->status=='expired')
<span class="badge badge-danger">Expired</span>
@else
<span class="badge badge-secondary">Inactive</span>
@endif
</td>
</tr>

<tr>
<th>Used</th>
<td>
@if($stock->is_used)
<span class="badge badge-warning">Used</span>
@else
<span class="badge badge-info">Unused</span>
@endif
</td>
</tr>

<tr>
<th>Issued At</th>
<td>{{ optional($stock->issued_at)->format('d M Y H:i') }}</td>
</tr>

<tr>
<th>Expiry Date</th>
<td>{{ optional($stock->expires_at)->format('d M Y') }}</td>
</tr>

<tr>
<th>Purchase Reference</th>
<td>{{ $stock->purchase_reference ?? 'N/A' }}</td>
</tr>

<tr>
<th>Notes</th>
<td>{{ $stock->notes ?? 'No notes available' }}</td>
</tr>

<tr>
<th>Created At</th>
<td>{{ optional($stock->created_at)->format('d M Y H:i') }}</td>
</tr>

<tr>
<th>Last Updated</th>
<td>{{ optional($stock->updated_at)->format('d M Y H:i') }}</td>
</tr>

</table>

</div>

</div>

</div>

{{-- USER DETAILS --}}

<div class="col-md-5">

<div class="card border-0 shadow-sm mb-4">

<div class="card-header bg-info text-white">
<strong>User Details</strong>
</div>

<div class="card-body text-center">

@if($stock->user)

<div class="mb-3">

@if($stock->user->profilePhoto()) <img src="{{ asset('storage/'.$stock->user->profilePhoto()->file_name) }}"
class="rounded-circle shadow"
width="80">

@else

<img src="https://ui-avatars.com/api/?name={{ $stock->user->name }}"
class="rounded-circle shadow"
width="80">

@endif

</div>

<h5 class="mb-1">{{ $stock->user->name }}</h5>

<p class="text-muted mb-2">{{ $stock->user->email }}</p>

<hr>

<table class="table table-sm">

<tr>
<th>User ID</th>
<td>{{ $stock->user->id }}</td>
</tr>

<tr>
<th>Email</th>
<td>{{ $stock->user->email }}</td>
</tr>

<tr>
<th>Account Created</th>
<td>{{ optional($stock->user->created_at)->format('d M Y') }}</td>
</tr>

<tr>
<th>Roles</th>
<td>

@foreach($stock->user->roles as $role)

<span class="badge badge-secondary">
{{ $role->name ?? $role->slug }}
</span>

@endforeach

</td>
</tr>

</table>

@else

<p class="text-muted">
License not assigned to any user yet.
</p>

@endif

</div>

</div>

</div>

</div>

</div>

<div class="card-footer text-right">

<a href="{{ route('admin.stocks.index') }}" class="btn btn-secondary">

<i class="fas fa-arrow-left"></i> Back

</a>

</div>

</div>

</div>

</div>

</div>

@endsection
