@extends('layouts.admin')

@section('title','Licenses')

@section('content')

<div class="card shadow-sm">

<div class="card-header d-flex justify-content-between align-items-center">

<h3 class="card-title font-weight-bold">License Management</h3>

<a href="{{ route('admin.licenses.create') }}" class="btn btn-primary">
<i class="fas fa-plus"></i> Generate Licenses
</a>

</div>

<div class="card-body table-responsive">

<table class="table table-hover table-bordered align-middle" id="userTable">

<thead class="thead-dark">

<tr>
<th>ID</th>
<th>License Key</th>
<th>Product</th>
<th>Plan</th>
<th>Status</th>
<th>Used</th>
<th>Expires</th>
<th width="160">Action</th>
</tr>

</thead>

<tbody>

@foreach($licenses as $license)

<tr>

<td>{{ $license->id }}</td>

<td>
<span class="badge badge-dark p-2">
{{ $license->license_key }}
</span>
</td>

<td>{{ $license->product_name }}</td>

<td>{{ $license->plan_name }}</td>

<td>

@if($license->status=='active') <span class="badge badge-success">Active</span>
@elseif($license->status=='expired') <span class="badge badge-danger">Expired</span>
@else <span class="badge badge-secondary">Inactive</span>
@endif

</td>

<td>

@if($license->is_used) <span class="badge badge-warning">Used</span>
@else <span class="badge badge-info">Unused</span>
@endif

</td>

<td>{{ optional($license->expires_at)->format('d M Y') }}</td>

<td>

<a href="{{ route('admin.licenses.show',$license->id) }}"
class="btn btn-sm btn-info"> <i class="fas fa-eye"></i> </a>

<a href="{{ route('admin.licenses.edit',$license->id) }}"
class="btn btn-sm btn-warning"> <i class="fas fa-edit"></i> </a>

<form action="{{ route('admin.licenses.destroy',$license->id) }}"
method="POST"
style="display:inline-block">

@csrf
@method('DELETE')

<button class="btn btn-sm btn-danger"
onclick="return confirm('Delete this license?')">

<i class="fas fa-trash"></i>

</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

<div class="mt-3">

{{ $licenses->links() }}

</div>

</div>

</div>

@endsection
@section('scripts')

<script>

	$(document).ready(function(){

		$('#userTable').DataTable({

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

	$(document).on('click','.deleteUser',function(){

		let form = $(this).closest('form');

		Swal.fire({

			title:'Are you sure?',
			text:'This user will be deleted permanently!',
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
