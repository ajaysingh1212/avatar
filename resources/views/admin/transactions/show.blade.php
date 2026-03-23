@extends('layouts.admin')

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between">
        <h3>Transaction Details</h3>

        <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary btn-sm">
            Back
        </a>
    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <tr>
                <th>ID</th>
                <td>{{ $txn->id }}</td>
            </tr>

            <tr>
                <th>Wallet</th>
                <td>{{ $txn->wallet->wallet_number }}</td>
            </tr>

            <tr>
                <th>User</th>
                <td>{{ $txn->wallet->user->name ?? '-' }}</td>
            </tr>

            <tr>
                <th>Email</th>
                <td>{{ $txn->wallet->user->email ?? '-' }}</td>
            </tr>

            <tr>
                <th>Amount</th>
                <td>₹ {{ number_format($txn->amount,2) }}</td>
            </tr>

            <tr>
                <th>Status</th>
                <td>
                    <span class="badge
                        @if($txn->status=='approved') badge-success
                        @elseif($txn->status=='pending') badge-warning
                        @elseif($txn->status=='hold') badge-info
                        @else badge-danger
                        @endif
                    ">
                        {{ ucfirst($txn->status) }}
                    </span>
                </td>
            </tr>

            <tr>
                <th>Before Balance</th>
                <td>{{ $txn->before_balance }}</td>
            </tr>

            <tr>
                <th>After Balance</th>
                <td>{{ $txn->after_balance }}</td>
            </tr>

            <tr>
                <th>Date</th>
                <td>{{ $txn->created_at }}</td>
            </tr>

        </table>

    </div>

</div>

@endsection
