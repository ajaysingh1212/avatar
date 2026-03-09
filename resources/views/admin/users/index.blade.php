@extends('layouts.admin')

@section('title','Users Management')

@section('content')

<div class="card shadow-lg border-0">

	<div class="card-header d-flex justify-content-between align-items-center">

		<h3 class="card-title">
			<i class="fas fa-users mr-2"></i> Users List
		</h3>

		<a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
			<i class="fas fa-user-plus"></i> Add User
		</a>

	</div>


	<div class="card-body">

		<table id="userTable" class="table table-hover table-striped table-bordered">

			<thead class="bg-dark text-white">

				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Email</th>
					<th>Role</th>
					<th width="200">Action</th>
				</tr>

			</thead>

			<tbody>

				@foreach($users as $user)

				<tr>

					<td>{{ $user->id }}</td>

					<td>
						<i class="fas fa-user-circle text-primary"></i>
						{{ $user->name }}
					</td>

					<td>
						<i class="fas fa-envelope text-info"></i>
						{{ $user->email }}
					</td>

					<td>

						<span class="badge badge-success">

							{{ $user->roles->pluck('name')->implode(',') }}

						</span>

					</td>

					<td>

						<a href="{{ route('admin.users.show',$user->id) }}"
							class="btn btn-info btn-sm action-btn">

							<i class="fas fa-eye"></i>

						</a>


						<a href="{{ route('admin.users.edit',$user->id) }}"
							class="btn btn-warning btn-sm action-btn">

							<i class="fas fa-edit"></i>

						</a>


						<form action="{{ route('admin.users.destroy',$user->id) }}"
							method="POST"
							style="display:inline">

							@csrf
							@method('DELETE')

							<button type="button"
							class="btn btn-danger btn-sm deleteUser action-btn">

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
