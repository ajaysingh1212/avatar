@extends('layouts.admin')

@section('content')

<div class="container-fluid">

<div class="card">

<div class="card-header">

<h3 class="card-title">

Edit Wallet : {{ $wallet->wallet_number }}

</h3>

<a href="{{ route('admin.wallets.index') }}" class="btn btn-secondary float-right">

<i class="fas fa-arrow-left"></i> Back

</a>

</div>

<div class="card-body">

<form method="POST" action="{{ route('admin.wallets.update',$wallet->id) }}">

@csrf
@method('PUT')


{{-- BASIC INFO --}}

<div class="row">

<div class="col-md-6">

<div class="form-group">

<label>Wallet Number</label>

<input type="text"
class="form-control"
value="{{ $wallet->wallet_number }}"
readonly>

</div>

</div>


<div class="col-md-6">

<div class="form-group">

<label>Balance</label>

<input type="number"
step="0.01"
name="balance"
class="form-control"
value="{{ old('balance',$wallet->balance) }}">

</div>

</div>

</div>


{{-- STATUS --}}

<div class="row">

<div class="col-md-4">

<div class="form-group">

<label>Status</label>

<select name="status" class="form-control">

<option value="pending"
{{ $wallet->status=='pending'?'selected':'' }}>
Pending
</option>

<option value="approved"
{{ $wallet->status=='approved'?'selected':'' }}>
Approved
</option>

<option value="rejected"
{{ $wallet->status=='rejected'?'selected':'' }}>
Rejected
</option>

</select>

</div>

</div>


<div class="col-md-4">

<div class="form-group">

<label>Freeze Wallet</label>

<select name="is_frozen" class="form-control">

<option value="0"
{{ !$wallet->is_frozen ? 'selected':'' }}>
Active
</option>

<option value="1"
{{ $wallet->is_frozen ? 'selected':'' }}>
Frozen
</option>

</select>

</div>

</div>


<div class="col-md-4">

<div class="form-group">

<label>Fraud Flag</label>

<select name="fraud_flag" class="form-control">

<option value="0"
{{ !$wallet->fraud_flag ? 'selected':'' }}>
Normal
</option>

<option value="1"
{{ $wallet->fraud_flag ? 'selected':'' }}>
Fraud Suspected
</option>

</select>

</div>

</div>

</div>


{{-- LIMITS --}}

<h5 class="mt-4 mb-3">Wallet Limits</h5>

<div class="row">

<div class="col-md-4">

<div class="form-group">

<label>Daily Limit</label>

<input type="number"
name="daily_limit"
class="form-control"
value="{{ old('daily_limit',$wallet->daily_limit) }}">

</div>

</div>


<div class="col-md-4">

<div class="form-group">

<label>Monthly Limit</label>

<input type="number"
name="monthly_limit"
class="form-control"
value="{{ old('monthly_limit',$wallet->monthly_limit) }}">

</div>

</div>


<div class="col-md-4">

<div class="form-group">

<label>Single Transaction Limit</label>

<input type="number"
name="single_txn_limit"
class="form-control"
value="{{ old('single_txn_limit',$wallet->single_txn_limit) }}">

</div>

</div>

</div>


{{-- USAGE STATS --}}

<h5 class="mt-4 mb-3">Usage Statistics</h5>

<div class="row">

<div class="col-md-6">

<div class="form-group">

<label>Daily Used</label>

<input type="text"
class="form-control"
value="₹ {{ number_format($wallet->daily_used,2) }}"
readonly>

</div>

</div>


<div class="col-md-6">

<div class="form-group">

<label>Monthly Used</label>

<input type="text"
class="form-control"
value="₹ {{ number_format($wallet->monthly_used,2) }}"
readonly>

</div>

</div>

</div>


{{-- FRAUD SCORE --}}

<div class="form-group">

<label>Fraud Score</label>

<input type="number"
name="fraud_score"
class="form-control"
value="{{ $wallet->fraud_score }}">

</div>


{{-- AUDIT INFO --}}

<h5 class="mt-4 mb-3">Audit Information</h5>

<table class="table table-bordered">

<tr>

<th>Created At</th>

<td>{{ $wallet->created_at }}</td>

</tr>

<tr>

<th>Created IP</th>

<td>{{ $wallet->created_ip }}</td>

</tr>

<tr>

<th>Last Updated IP</th>

<td>{{ $wallet->updated_ip }}</td>

</tr>

<tr>

<th>Approved At</th>

<td>{{ $wallet->approved_at }}</td>

</tr>

</table>


{{-- SAVE BUTTON --}}

<div class="text-right">

<button class="btn btn-primary">

<i class="fas fa-save"></i> Update Wallet

</button>

</div>

</form>

</div>

</div>

</div>

@endsection
