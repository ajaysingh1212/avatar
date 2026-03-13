@extends('layouts.admin')

@section('title','Generate Licenses')

@section('content')

<div class="card card-primary shadow-sm">

<div class="card-header">
<h3 class="card-title">Generate Licenses</h3>
</div>

<form method="POST" action="{{ route('admin.licenses.store') }}">

@csrf

<div class="card-body">

<div class="row">

<div class="col-md-4">

<div class="form-group">
<label>Quantity</label>
<input type="number" name="quantity" class="form-control" required>
</div>

</div>

<div class="col-md-4">

<div class="form-group">
<label>Product Name</label>
<input type="text" name="product_name" class="form-control" required>
</div>

</div>

<div class="col-md-4">

<div class="form-group">
<label>Plan Name</label>
<input type="text" name="plan_name" class="form-control" required>
</div>

</div>

<div class="col-md-4">

<div class="form-group">
<label>Max Devices</label>
<input type="number" name="max_devices" class="form-control">
</div>

</div>

<div class="col-md-4">

<div class="form-group">
<label>Validity (Days)</label>
<input type="number" name="validity_days" class="form-control">
</div>

</div>

<div class="col-md-12">

<div class="form-group">
<label>Notes</label>
<textarea name="notes" class="form-control"></textarea>
</div>

</div>

</div>

</div>

<div class="card-footer">

<button class="btn btn-primary">
Generate Licenses
</button>

<a href="{{ route('admin.licenses.index') }}"
class="btn btn-secondary">

Cancel

</a>

</div>

</form>

</div>

@endsection
