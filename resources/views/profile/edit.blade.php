@extends('layouts.admin')

@section('title','My Profile')

@section('content')

<div class="profile-container">

<!-- Cover Photo -->

@php
$cover = auth()->user()->media->where('collection_name','cover')->first();
@endphp

<div class="cover-photo">

@if($cover)

<img
id="coverPreview"
src="{{ asset('storage/'.$cover->file_name) }}"
class="cover-img">

@else

<img
id="coverPreview"
src="https://picsum.photos/1200/350"
class="cover-img">

@endif


<label class="cover-upload">

<i class="fas fa-camera"></i>

<input
type="file"
name="cover_photo"
form="profileForm"
id="coverInput">

</label>

</div>


<!-- Profile Section -->

<div class="profile-info">

<div class="profile-avatar">

@php
$profile = auth()->user()->media->where('collection_name','profile')->first();
@endphp

@if($profile)

<img
id="profilePreview"
src="{{ asset('storage/'.$profile->file_name) }}"
class="avatar-img">

@else

<img
id="profilePreview"
src="https://i.pravatar.cc/150"
class="avatar-img">

@endif


<label class="avatar-upload">

<i class="fas fa-camera"></i>

<input
type="file"
name="profile_photo"
form="profileForm"
id="profileInput">

</label>

</div>


<div class="profile-name">

<h2>{{ auth()->user()->name }}</h2>

<p>{{ auth()->user()->email }}</p>

</div>

</div>


<!-- Edit Form -->

<div class="card profile-card">

<form
id="profileForm"
method="POST"
action="{{ route('profile.update') }}"
enctype="multipart/form-data">

@csrf
@method('PATCH')

<div class="card-body">

<div class="row">

<div class="col-md-6">

<label>Name</label>

<input
type="text"
name="name"
value="{{ auth()->user()->name }}"
class="form-control">

</div>


<div class="col-md-6">

<label>Email</label>

<input
type="email"
name="email"
value="{{ auth()->user()->email }}"
class="form-control">

</div>

</div>


<br>


<div class="row">

<div class="col-md-6">

<label>New Password</label>

<input
type="password"
name="password"
class="form-control"
placeholder="Enter new password">

</div>

</div>

</div>


<div class="card-footer text-right">

<button class="btn btn-primary">

<i class="fas fa-save"></i>

Update Profile

</button>

</div>

</form>

</div>

</div>

@endsection


<style>

.profile-container{
background:#111827;
padding:20px;
border-radius:10px;
}

.cover-photo{
position:relative;
height:320px;
overflow:hidden;
border-radius:10px;
}

.cover-img{
width:100%;
height:320px;
object-fit:cover;
transition:0.4s;
}

.cover-img:hover{
transform:scale(1.03);
}

.cover-upload{
position:absolute;
bottom:15px;
right:20px;
background:#000000aa;
padding:10px;
border-radius:50%;
cursor:pointer;
color:#fff;
transition:0.3s;
}

.cover-upload:hover{
background:#2563eb;
}

.cover-upload input{
display:none;
}

.profile-info{
display:flex;
align-items:center;
margin-top:-60px;
padding-left:40px;
}

.profile-avatar{
position:relative;
}

.avatar-img{
width:120px;
height:120px;
border-radius:50%;
border:5px solid #111827;
object-fit:cover;
transition:0.4s;
}

.avatar-img:hover{
transform:scale(1.05);
}

.avatar-upload{
position:absolute;
bottom:0;
right:0;
background:#000000aa;
padding:6px;
border-radius:50%;
cursor:pointer;
transition:0.3s;
}

.avatar-upload:hover{
background:#2563eb;
}

.avatar-upload input{
display:none;
}

.profile-name{
margin-left:20px;
color:#fff;
}

.profile-card{
margin-top:30px;
background:#1f2937;
color:#fff;
}

.form-control{
background:#111827;
border:1px solid #374151;
color:#fff;
}

.btn{
transition:0.3s;
}

.btn:hover{
transform:scale(1.05);
}

</style>


<script>

document.getElementById('profileInput').addEventListener('change',function(e){

const reader = new FileReader();

reader.onload = function(){

document.getElementById('profilePreview').src = reader.result;

};

reader.readAsDataURL(e.target.files[0]);

});


document.getElementById('coverInput').addEventListener('change',function(e){

const reader = new FileReader();

reader.onload = function(){

document.getElementById('coverPreview').src = reader.result;

};

reader.readAsDataURL(e.target.files[0]);

});

</script>
