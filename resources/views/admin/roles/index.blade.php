@extends('layouts.admin')

@section('title','Roles')

@section('content')

<div class="card shadow">

<div class="card-header d-flex justify-content-between">

<h3><i class="fas fa-user-tag"></i> Roles</h3>

<a href="{{ route('admin.roles.create') }}" class="btn btn-primary btn-sm">
<i class="fas fa-plus"></i> Create Role
</a>

</div>

<div class="card-body">

<table class="table table-bordered table-hover">

<thead class="bg-dark">

<tr>
<th>ID</th>
<th>Name</th>
<th>Slug</th>
<th width="200">Action</th>
</tr>

</thead>

<tbody>

@foreach($roles as $role)

<tr>

<td>{{ $role->id }}</td>

<td>
<span class="badge badge-info">
{{ $role->name }}
</span>
</td>

<td>{{ $role->slug }}</td>

<td>

<a href="{{ route('admin.roles.show',$role->id) }}"
class="btn btn-info btn-sm">

<i class="fas fa-eye"></i>

</a>

<a href="{{ route('admin.roles.edit',$role->id) }}"
class="btn btn-warning btn-sm">

<i class="fas fa-edit"></i>

</a>

<form action="{{ route('admin.roles.destroy',$role->id) }}"
method="POST"
style="display:inline">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm">

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
