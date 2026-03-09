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

<table id="userTable" class="table table-bordered table-hover">

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
