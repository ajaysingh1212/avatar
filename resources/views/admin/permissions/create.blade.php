@extends('layouts.admin')

@section('title','Create Permission')

@section('content')

<div class="card">

<div class="card-header">
Create Permission
</div>

<form action="{{ route('admin.permissions.store') }}" method="POST">

@csrf

<div class="card-body">

<label>Name</label>

<input type="text" name="name" class="form-control">

<br>

<label>Slug</label>

<input type="text" name="slug" class="form-control">

</div>

<div class="card-footer">

<button class="btn btn-success">

Save Permission

</button>

</div>

</form>

</div>

@endsection
