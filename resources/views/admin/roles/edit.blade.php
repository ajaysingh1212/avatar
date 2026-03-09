@extends('layouts.admin')

@section('title','Edit Role')

@section('content')

<div class="card">

	<div class="card-header">
		Edit Role
	</div>

	<form action="{{ route('admin.roles.update',$role->id) }}" method="POST">

		@csrf
		@method('PUT')

		<div class="card-body">

			<div class="form-group">

				<label>Role Name</label>

				<input type="text"
				name="name"
				value="{{ $role->name }}"
				class="form-control">

			</div>


			<div class="form-group">

				<label>Slug</label>

				<input type="text"
				name="slug"
				value="{{ $role->slug }}"
				class="form-control">

			</div>


			<h5>Permissions</h5>

			<div class="row">

				@foreach($permissions as $permission)

				<div class="col-md-3">

					<label>

						<input
						type="checkbox"
						name="permissions[]"
						value="{{ $permission->id }}"
						{{ in_array($permission->id,$rolePermissions) ? 'checked' : '' }}>

						{{ $permission->name }}

					</label>

				</div>

				@endforeach

			</div>

		</div>

		<div class="card-footer">

			<button class="btn btn-success">

				<i class="fas fa-save"></i> Update

			</button>

		</div>

	</form>

</div>

@endsection
