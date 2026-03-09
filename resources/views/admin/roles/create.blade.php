@extends('layouts.admin')

@section('title','Create Role')

@section('content')

<div class="card shadow-lg border-0">

	<div class="card-header d-flex justify-content-between align-items-center">

		<h3 class="card-title">
			<i class="fas fa-user-shield"></i> Create Role
		</h3>

		<div>

			<button type="button" id="selectAll"
			class="btn btn-success btn-sm">

			<i class="fas fa-check-circle"></i>
			Select All

		</button>

		<button type="button" id="deselectAll"
		class="btn btn-danger btn-sm">

		<i class="fas fa-times-circle"></i>
		Deselect All

	</button>

</div>

</div>

<form action="{{ route('admin.roles.store') }}" method="POST">

	@csrf

	<div class="card-body">

		<div class="row">

			<div class="col-md-6">

				<label>Role Name</label>

				<input type="text"
				name="name"
				class="form-control"
				placeholder="Enter Role Name">

			</div>

			<div class="col-md-6">

				<label>Slug</label>

				<input type="text"
				name="slug"
				class="form-control"
				placeholder="role-slug">

			</div>

		</div>

		<hr>

		<h5 class="mb-3">
			<i class="fas fa-key"></i>
			Permissions
		</h5>

		<div class="row">

			@foreach($permissions as $permission)

			<div class="col-md-3 mb-3">

				<label class="permission-card">

					<input
					type="checkbox"
					name="permissions[]"
					value="{{ $permission->id }}"
					class="permission-checkbox">

					<span class="checkmark"></span>

					{{ $permission->name }}

				</label>

			</div>

			@endforeach

		</div>

	</div>

	<div class="card-footer">

		<button class="btn btn-primary">

			<i class="fas fa-save"></i>
			Create Role

		</button>

	</div>

</form>

</div>

@endsection


@section('scripts')

<script>

	$('#selectAll').click(function(){

		$('.permission-checkbox').prop('checked',true);

	});

	$('#deselectAll').click(function(){

		$('.permission-checkbox').prop('checked',false);

	});

</script>

<style>

	.permission-card{

		display:block;
		padding:10px 12px;
		border-radius:8px;
		background:#1f2937;
		cursor:pointer;
		transition:0.3s;
		border:1px solid #374151;

	}

	.permission-card:hover{

		background:#374151;
		transform:scale(1.03);
		box-shadow:0 4px 15px rgba(0,0,0,0.4);

	}

	.permission-card input{

		margin-right:8px;

	}

	.permission-checkbox{

		transform:scale(1.2);

	}

</style>

@endsection
