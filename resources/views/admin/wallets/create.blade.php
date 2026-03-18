@extends('layouts.admin')

@section('content')

<div class="card">

<div class="card-header">
<h3>Create Wallet</h3>
</div>

<div class="card-body">

{{-- GLOBAL ERROR MESSAGE --}}
@if ($errors->any())
<div class="alert alert-danger">
<strong>Whoops!</strong> Please fix the following errors:
<ul class="mb-0">
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<form method="POST" action="{{ route('admin.wallets.store') }}">

@csrf

<div class="form-group">

<label>User</label>

<select name="user_id"
class="form-control @error('user_id') is-invalid @enderror">

<option value="">Select User</option>

@foreach($users as $user)

<option value="{{ $user->id }}"
{{ old('user_id') == $user->id ? 'selected' : '' }}>
{{ $user->name }}
</option>

@endforeach

</select>

@error('user_id')
<span class="invalid-feedback">
<strong>{{ $message }}</strong>
</span>
@enderror

</div>

<button class="btn btn-primary">
Create Wallet
</button>

<a href="{{ route('admin.wallets.index') }}"
class="btn btn-secondary">
Cancel
</a>

</form>

</div>

</div>

@endsection
