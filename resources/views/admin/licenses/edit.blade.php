@extends('layouts.admin')

@section('title','Edit License')

@section('content')

<div class="card card-warning shadow-sm">

<div class="card-header">
<h3 class="card-title">Edit License</h3>
</div>

<form method="POST"
action="{{ route('admin.licenses.update',$license->id) }}">

@csrf
@method('PUT')

<div class="card-body">

<div class="row">

<div class="col-md-6">

<div class="form-group">
<label>License Key</label>
<input type="text"
class="form-control"
value="{{ $license->license_key }}"
readonly>
</div>

</div>

<div class="col-md-6">

<div class="form-group">
<label>Status</label>

<select name="status" class="form-control">

<option value="active"
{{ $license->status=='active'?'selected':'' }}>
Active
</option>

<option value="inactive"
{{ $license->status=='inactive'?'selected':'' }}>
Inactive
</option>

<option value="expired"
{{ $license->status=='expired'?'selected':'' }}>
Expired
</option>

</select>

</div>

</div>

<div class="col-md-6">

<div class="form-group">
<label>Product</label>
<input type="text"
name="product_name"
value="{{ $license->product_name }}"
class="form-control">
</div>

</div>

<div class="col-md-6">

<div class="form-group">
<label>Plan</label>
<input type="text"
name="plan_name"
value="{{ $license->plan_name }}"
class="form-control">
</div>

</div>

<div class="col-md-6">

<div class="form-group">
<label>Max Devices</label>
<input type="number"
name="max_devices"
value="{{ $license->max_devices }}"
class="form-control">
</div>

</div>

<div class="col-md-12">

<div class="form-group">
<label>Notes</label>

<textarea name="notes"
class="form-control">

{{ $license->notes }}

</textarea>

</div>

</div>

</div>

</div>

<div class="card-footer">

<button class="btn btn-warning">
Update License
</button>

</div>

</form>

</div>

@endsection
