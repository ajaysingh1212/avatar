@extends('layouts.admin')

@section('title','Stock Report')

@section('content')

<div class="card shadow-lg">

<div class="card-header">
<h3>Stock Transfer Report</h3>
</div>

<div class="card-body">

<form method="POST"
action="{{ route('admin.stock-report.search') }}">

@csrf

<div class="row">

<div class="col-md-3">

<label>Select Role</label>

<select id="roleSelect" class="form-control">

<option value="">Select Role</option>

@foreach($roles as $role)

<option value="{{ $role->slug }}">
{{ $role->name }}
</option>

@endforeach

</select>

</div>


<div class="col-md-3">

<label>Select User</label>

<select name="user_id" id="userSelect"
class="form-control">

<option>Select User</option>

</select>

</div>


<div class="col-md-3">

<label>From Date</label>

<input type="date"
name="from_date"
class="form-control">

</div>


<div class="col-md-3">

<label>To Date</label>

<input type="date"
name="to_date"
class="form-control">

</div>

</div>

<button class="btn btn-primary mt-3">
Generate Report
</button>

</form>

</div>

</div>



@if(!empty($reports))

<div class="card shadow-lg mt-4">

<div class="card-header">

<h4>Transfer History</h4>

</div>

<div class="card-body">

<table class="table table-bordered">

<thead>

<tr>

<th>Transfer ID</th>
<th>User</th>
<th>License</th>
<th>Product</th>
<th>Plan</th>
<th>Price</th>
<th>Discount</th>
<th>Total</th>
<th>Date</th>

</tr>

</thead>

<tbody>

@foreach($reports as $transfer)

@foreach($transfer->items as $item)

<tr>

<td>{{ $transfer->id }}</td>

<td>{{ $transfer->user->name }}</td>

<td>{{ $item->license->license_key }}</td>

<td>{{ $item->license->product_name }}</td>

<td>{{ $item->license->plan_name }}</td>

<td>{{ $item->price }}</td>

<td>{{ $item->discount }}</td>

<td>{{ $item->total }}</td>

<td>{{ $transfer->created_at }}</td>

</tr>

@endforeach

@endforeach

</tbody>

</table>

</div>

</div>

@endif



@if(!empty($currentStocks))

<div class="card shadow-lg mt-4">

<div class="card-header">

<h4>Current Stock</h4>

</div>

<div class="card-body">

<table class="table table-bordered">

<thead>

<tr>

<th>License</th>
<th>Product</th>
<th>Plan</th>
<th>Status</th>
<th>Expiry</th>

</tr>

</thead>

<tbody>

@foreach($currentStocks as $stock)

<tr>

<td>{{ $stock->license_key }}</td>

<td>{{ $stock->product_name }}</td>

<td>{{ $stock->plan_name }}</td>

<td>{{ $stock->status }}</td>

<td>{{ $stock->expires_at }}</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

@endif

@endsection



@section('scripts')

<script>

$('#roleSelect').change(function(){

let role = $(this).val()

$.get('/admin/stock-report-users/'+role,function(res){

$('#userSelect').html(res)

})

})

</script>

@endsection
