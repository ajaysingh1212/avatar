@extends('layouts.admin')

@section('title','Dashboard')

@section('content')

<div class="row">

	<div class="col-lg-3 col-6">

		<div class="small-box bg-info">

			<div class="inner">
				<h3>{{ \App\Models\User::count() }}</h3>
				<p>Total Users</p>
			</div>

			<div class="icon">
				<i class="fas fa-users"></i>
			</div>

		</div>

	</div>



	<div class="col-lg-3 col-6">

		<div class="small-box bg-success">

			<div class="inner">
				<h3>{{ \App\Models\Role::count() }}</h3>
				<p>Total Roles</p>
			</div>

			<div class="icon">
				<i class="fas fa-user-tag"></i>
			</div>

		</div>

	</div>



	<div class="col-lg-3 col-6">

		<div class="small-box bg-warning">

			<div class="inner">
				<h3>{{ \App\Models\Permission::count() }}</h3>
				<p>Total Permissions</p>
			</div>

			<div class="icon">
				<i class="fas fa-key"></i>
			</div>

		</div>

	</div>

</div>

@endsection
