@extends('layouts.admin')

@section('title','License Transfers')

@section('content')

<div class="card shadow-lg">

<div class="card-header d-flex justify-content-between align-items-center">

<h3 class="mb-0">License Transfers</h3>

<a href="{{ route('admin.license-transfer.create') }}"
class="btn btn-primary">

<i class="fas fa-plus"></i> New Transfer

</a>

</div>

<div class="card-body">

<table class="table table-bordered table-hover align-middle" id="transferTable">

<thead class="thead-dark">

<tr>

<th>ID</th>
<th>Reseller</th>
<th>Licenses</th>
<th>Products</th>
<th>Total Licenses</th>
<th>Total Amount</th>
<th>Date</th>
<th width="180">Action</th>

</tr>

</thead>

<tbody>

@foreach($transfers as $transfer)

<tr>

<td>
<span class="badge badge-dark">
#{{ $transfer->id }}
</span>
</td>

<td>

<strong>
{{ optional($transfer->user)->name }}
</strong>

<br>

<small class="text-muted">
{{ optional($transfer->user)->email }}
</small>

</td>


<td>

@foreach($transfer->items as $item)

<div class="badge badge-secondary p-2 mb-1">

{{ $item->license->license_key }}

</div>

@endforeach

</td>


<td>

@foreach($transfer->items as $item)

<div class="mb-1">

<strong>
{{ $item->license->product_name }}
</strong>

<br>

<small class="text-muted">

Plan:
{{ $item->license->plan_name }}

</small>

</div>

@endforeach

</td>


<td>

<span class="badge badge-info p-2">

{{ $transfer->total_licenses }}

</span>

</td>


<td>

@php

$total = $transfer->items->sum('total');

@endphp

<span class="text-success font-weight-bold">

₹ {{ number_format($total,2) }}

</span>

</td>


<td>

{{ $transfer->created_at->format('d M Y') }}

</td>


<td>

<a href="{{ route('admin.license-transfer.show',$transfer->id) }}"
class="btn btn-info btn-sm action-btn">

<i class="fas fa-eye"></i>

</a>

<a href="{{ route('admin.license-transfer.edit',$transfer->id) }}"
class="btn btn-warning btn-sm action-btn">

<i class="fas fa-edit"></i>

</a>

<form action="{{ route('admin.license-transfer.destroy',$transfer->id) }}"
method="POST"
style="display:inline-block">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm action-btn deleteTransfer">

<i class="fas fa-trash"></i>

</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

@endsection



@section('scripts')

<script>

$(document).ready(function(){

$('#transferTable').DataTable({

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



// SweetAlert Delete

$(document).on('click','.deleteTransfer',function(e){

e.preventDefault();

let form = $(this).closest('form');

Swal.fire({

title:'Are you sure?',
text:'This transfer will be deleted permanently!',
icon:'warning',
showCancelButton:true,
confirmButtonColor:'#d33',
confirmButtonText:'Yes Delete'

}).then((result)=>{

if(result.isConfirmed){

form.submit();

}

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
