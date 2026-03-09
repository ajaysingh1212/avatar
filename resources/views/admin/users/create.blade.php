@extends('layouts.admin')

@section('title','Create User')

@section('content')

<div class="card shadow-lg">

<div class="card-header">
<h3>Create User</h3>
</div>

<form action="{{ route('admin.users.store') }}" method="POST">

@csrf

<div class="card-body">

<div class="row">

<div class="col-md-6">

<label>Name</label>

<input type="text" name="name" class="form-control">

</div>

<div class="col-md-6">

<label>Email</label>

<input type="email" name="email" class="form-control">

</div>

</div>

<br>

<div class="row">

<div class="col-md-6">

<label>Password</label>

<input type="password" name="password" class="form-control">

</div>

<div class="col-md-6">

<label>Role</label>

<select name="roles[]" class="form-control">

@foreach($roles as $role)

<option value="{{ $role->id }}">
{{ $role->name }}
</option>

@endforeach

</select>

</div>

</div>

</div>

<div class="card-footer">

<button class="btn btn-success">
<i class="fas fa-save"></i> Save
</button>

</div>

</form>

</div>

@endsection
