@extends('layouts.admin')

@section('title','Edit Permission')

@section('content')

<div class="card">

<div class="card-header">
Edit Permission
</div>

<form action="{{ route('admin.permissions.update',$permission->id) }}" method="POST">

@csrf
@method('PUT')

<div class="card-body">

<div class="form-group">

<label>Name</label>

<input
type="text"
name="name"
value="{{ $permission->name }}"
class="form-control">

</div>

<div class="form-group">

<label>Slug</label>

<input
type="text"
name="slug"
value="{{ $permission->slug }}"
class="form-control">

</div>

</div>

<div class="card-footer">

<button class="btn btn-success">

Update

</button>

</div>

</form>

</div>

@endsection
