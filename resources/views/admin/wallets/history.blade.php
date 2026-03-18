@extends('layouts.admin')

@section('content')

<div class="card">

<div class="card-header">

<h3>Wallet History</h3>

</div>

<div class="card-body">

<table class="table table-bordered" id="userTable">

<thead>

<tr>

<th>ID</th>
<th>Action</th>
<th>Description</th>
<th>By</th>
<th>Date</th>

</tr>

</thead>

<tbody>

@foreach($history as $h)

<tr>

<td>{{ $h->id }}</td>

<td>{{ $h->action }}</td>

<td>{{ $h->description }}</td>

<td>{{ $h->performed_by }}</td>

<td>{{ $h->created_at }}</td>

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
