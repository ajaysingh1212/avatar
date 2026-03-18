@extends('layouts.admin')

@section('content')

<div class="card">

<div class="card-header">

<h3>Pending Transactions</h3>

</div>

<div class="card-body">

<table class="table table-bordered">

<thead>

<tr>

<th>ID</th>
<th>Wallet</th>
<th>Amount</th>
<th>Status</th>
<th>Action</th>

</tr>

</thead>

<tbody>

@foreach($transactions as $txn)

<tr>

<td>{{ $txn->id }}</td>

<td>{{ $txn->wallet->wallet_number }}</td>

<td>{{ $txn->amount }}</td>

<td>{{ $txn->status }}</td>

<td>

<form method="POST" action="{{ route('admin.transactions.approve',$txn->id) }}">

@csrf

<button class="btn btn-success btn-sm">Approve</button>

</form>

<form method="POST" action="{{ route('admin.transactions.reject',$txn->id) }}">

@csrf

<button class="btn btn-danger btn-sm">Reject</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

@endsection
