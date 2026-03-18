@extends('layouts.admin')

@section('title','License Stocks')

@section('content')

<div class="card shadow-sm">

<div class="card-header d-flex justify-content-between align-items-center">

<h3 class="card-title font-weight-bold">
Available License Stocks
</h3>

<span class="badge badge-primary p-2">
Total Stocks : {{ $stocks->total() }}
</span>

</div>


<div class="card-body table-responsive">

<table class="table table-hover table-bordered align-middle" id="stockTable">

<thead class="thead-dark">

<tr>
<th>ID</th>
<th>User</th>
<th>License Key</th>
<th>Product</th>
<th>Plan</th>
<th>Status</th>
<th>Devices</th>
<th>Validity</th>
<th>Expires</th>
<th width="120">Action</th>
</tr>

</thead>

<tbody>

@forelse($stocks as $license)

<tr>

<td>{{ $license->id }}</td>

<td>

@if($license->user)
<span class="badge badge-info">
{{ $license->user->name }}
</span>
@else
<span class="badge badge-secondary">
Admin Pool
</span>
@endif

</td>

<td>

<span class="badge badge-dark p-2">
{{ $license->license_key }}
</span>

</td>

<td>{{ $license->product_name }}</td>

<td>{{ $license->plan_name }}</td>

<td>

@if($license->status == 'active')
<span class="badge badge-success">
Active
</span>
@else
<span class="badge badge-secondary">
Inactive
</span>
@endif

</td>

<td>

<span class="badge badge-warning">
{{ $license->max_devices }}
</span>

</td>

<td>{{ $license->validity_days }} Days</td>

<td>

{{ optional($license->expires_at)->format('d M Y') }}

</td>

<td>

<a href="{{ route('admin.stocks.show',$license->id) }}"
class="btn btn-sm btn-info action-btn">

<i class="fas fa-eye"></i>

</a>

</td>

</tr>

@empty

<tr>

<td colspan="10" class="text-center text-muted">

No License Stock Available

</td>

</tr>

@endforelse

</tbody>

</table>

<div class="mt-3">

{{ $stocks->links() }}

</div>

</div>

</div>

@endsection


@section('scripts')

<script>

$(document).ready(function(){

$('#stockTable').DataTable({

pageLength:50,

lengthMenu:[
[10,25,50,100,500],
[10,25,50,100,500]
],

dom:'Bfrtip',

buttons:[

{
extend:'copy',
className:'btn btn-secondary btn-sm'
},

{
extend:'csv',
className:'btn btn-success btn-sm'
},

{
extend:'excel',
className:'btn btn-success btn-sm'
},

{
extend:'pdf',
className:'btn btn-danger btn-sm'
},

{
extend:'print',
className:'btn btn-info btn-sm'
},

{
extend:'colvis',
className:'btn btn-warning btn-sm'
}

]

});

});

</script>


<style>

.action-btn{
transition:0.3s;
}

.action-btn:hover{

transform:scale(1.15);
box-shadow:0px 3px 10px rgba(0,0,0,0.3);

}

.dataTables_wrapper .dt-buttons{
margin-bottom:10px;
}

</style>

@endsection
