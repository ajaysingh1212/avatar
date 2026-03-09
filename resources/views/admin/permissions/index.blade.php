@extends('layouts.admin')

@section('title','Permissions')

@section('content')

<div class="card">

<div class="card-header d-flex justify-content-between">

<h3>
<i class="fas fa-key"></i> Permissions
</h3>

<a href="{{ route('admin.permissions.create') }}"
class="btn btn-primary btn-sm">

<i class="fas fa-plus"></i>

Create Permission

</a>

</div>

<div class="card-body">

<table class="table table-bordered">

<thead class="bg-dark">

<tr>
<th>ID</th>
<th>Name</th>
<th>Slug</th>
<th width="200">Action</th>
</tr>

</thead>

<tbody>

@foreach($permissions as $permission)

<tr>

<td>{{ $permission->id }}</td>

<td>{{ $permission->name }}</td>

<td>{{ $permission->slug }}</td>

<td>

<a href="{{ route('admin.permissions.show',$permission->id) }}"
class="btn btn-info btn-sm">

<i class="fas fa-eye"></i>

</a>

<a href="{{ route('admin.permissions.edit',$permission->id) }}"
class="btn btn-warning btn-sm">

<i class="fas fa-edit"></i>

</a>

<form action="{{ route('admin.permissions.destroy',$permission->id) }}"
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
