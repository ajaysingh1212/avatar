@extends('layouts.admin')

@section('title','Edit User')

@section('content')

<div class="card">

<div class="card-header">
<h3>Edit User</h3>
</div>

<form action="{{ route('admin.users.update',$user->id) }}" method="POST">

@csrf
@method('PUT')

<div class="card-body">

<div class="form-group">

<label>Name</label>

<input type="text"
name="name"
value="{{ $user->name }}"
class="form-control">

</div>

<div class="form-group">

<label>Email</label>

<input type="email"
name="email"
value="{{ $user->email }}"
class="form-control">

</div>

<div class="form-group">

<label>Role</label>

<select name="roles[]" class="form-control">

@foreach($roles as $role)

<option
value="{{ $role->id }}"
{{ in_array($role->id,$userRoles) ? 'selected' : '' }}>

{{ $role->name }}

</option>

@endforeach

</select>

</div>

</div>

<div class="card-footer">

<button class="btn btn-primary">
Update
</button>

</div>

</form>

</div>

@endsection
