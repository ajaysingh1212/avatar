@extends('layouts.admin')

@section('content')

<div class="card">

<div class="card-header">

<h3>Transaction Details</h3>

</div>

<div class="card-body">

<table class="table table-bordered">

<tr>
<th>Transaction ID</th>
<td>{{ $transaction->transaction_id }}</td>
</tr>

<tr>
<th>Wallet</th>
<td>{{ $transaction->wallet->wallet_number }}</td>
</tr>

<tr>
<th>Amount</th>
<td>{{ $transaction->amount }}</td>
</tr>

<tr>
<th>Status</th>
<td>{{ $transaction->status }}</td>
</tr>

<tr>
<th>Created</th>
<td>{{ $transaction->created_at }}</td>
</tr>

</table>

</div>

</div>

@endsection
