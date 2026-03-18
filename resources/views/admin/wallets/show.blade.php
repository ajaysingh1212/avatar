@extends('layouts.admin')

@section('content')

<div class="container-fluid">

{{-- HEADER --}}

<div class="row mb-3">

<div class="col-md-8">

<h3>

Wallet : {{ $wallet->wallet_number }}

@if($wallet->is_frozen)
<span class="badge badge-danger ml-2">
<i class="fas fa-lock"></i> Frozen
</span>
@endif

</h3>

<p>User : <strong>{{ $wallet->user->name }}</strong></p>

</div>

<div class="col-md-4 text-right">

<a href="{{ route('admin.wallets.history',$wallet->id) }}"
class="btn btn-secondary">

<i class="fas fa-history"></i> Wallet History

</a>

</div>

</div>


{{-- WALLET CARDS --}}

<div class="row">

<div class="col-md-3">

<div class="card bg-success">

<div class="card-body">

<h5>Balance</h5>
<h3>₹ {{ number_format($wallet->balance,2) }}</h3>

</div>

</div>

</div>


<div class="col-md-3">

<div class="card bg-warning">

<div class="card-body">

<h5>Fraud Score</h5>
<h3>{{ $wallet->fraud_score }}</h3>

</div>

</div>

</div>


<div class="col-md-3">

<div class="card bg-info">

<div class="card-body">

<h5>Daily Used</h5>
<h3>₹ {{ number_format($wallet->daily_used,2) }}</h3>

</div>

</div>

</div>


<div class="col-md-3">

<div class="card bg-danger">

<div class="card-body">

<h5>Monthly Used</h5>
<h3>₹ {{ number_format($wallet->monthly_used,2) }}</h3>

</div>

</div>

</div>

</div>


{{-- FRAUD ALERT --}}

@if($wallet->fraud_flag)

<div class="alert alert-danger mt-3">

<i class="fas fa-exclamation-triangle"></i>

<strong>Fraud Alert:</strong>

Suspicious activity detected.

</div>

@endif


{{-- RISK SCORE BAR --}}

<div class="card mt-3">

<div class="card-header">

Risk Score

</div>

<div class="card-body">

<div class="progress">

<div class="progress-bar bg-danger"
style="width: {{ $wallet->fraud_score }}%">

{{ $wallet->fraud_score }} %

</div>

</div>

</div>

</div>


{{-- REAL TIME TRANSACTION GRAPH --}}

<div class="card mt-3">

<div class="card-header">

Real-time Transactions

</div>

<div class="card-body">

<canvas id="txnChart"></canvas>

</div>

</div>


{{-- WALLET HEATMAP --}}

<div class="card mt-3">

<div class="card-header">

Wallet Activity Heatmap

</div>

<div class="card-body">

<div id="heatmap" style="height:200px"></div>

</div>

</div>


{{-- LIVE TRANSACTIONS --}}

<div class="card mt-3">

<div class="card-header">

Live Wallet Monitoring

</div>

<div class="card-body">

<table class="table table-bordered" id="txnTable">

<thead>

<tr>

<th>ID</th>
<th>Txn ID</th>
<th>Type</th>
<th>Amount</th>
<th>Status</th>
<th>Time</th>

</tr>

</thead>

<tbody id="txnBody">

@foreach($wallet->transactions->take(10) as $txn)

<tr>

<td>{{ $txn->id }}</td>

<td>{{ $txn->transaction_id }}</td>

<td>

@if($txn->type=='credit')
<span class="badge badge-success">Credit</span>
@else
<span class="badge badge-danger">Debit</span>
@endif

</td>

<td>₹ {{ $txn->amount }}</td>

<td>{{ $txn->status }}</td>

<td>{{ $txn->created_at }}</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>


{{-- ADMIN RISK DASHBOARD --}}

<div class="card mt-3">

<div class="card-header">

Admin Risk Dashboard

</div>

<div class="card-body">

<div class="row">

<div class="col-md-4">

<div class="alert alert-warning">

High Transaction Frequency

</div>

</div>

<div class="col-md-4">

<div class="alert alert-info">

Multiple IP Login Detected

</div>

</div>

<div class="col-md-4">

<div class="alert alert-danger">

Risk Level :
@if($wallet->fraud_score > 70)
HIGH
@elseif($wallet->fraud_score > 40)
MEDIUM
@else
LOW
@endif

</div>

</div>

</div>

</div>

</div>


</div>

@endsection


@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/heatmap.js@2.0.5/build/heatmap.min.js"></script>


<script>

let ctx = document.getElementById('txnChart').getContext('2d');

let txnChart = new Chart(ctx, {

type: 'line',

data: {

labels: [],

datasets: [{
label: 'Transactions',
data: [],
borderColor: 'rgba(75,192,192,1)',
fill:false
}]

},

options:{
responsive:true
}

});



/* AUTO REFRESH GRAPH */

function updateChart(){

fetch("{{ route('admin.wallet.analytics',$wallet->id) }}")

.then(res => res.json())

.then(data => {

txnChart.data.labels = data.labels;
txnChart.data.datasets[0].data = data.values;
txnChart.update();

});

}

setInterval(updateChart,5000);



/* AUTO REFRESH TRANSACTIONS */

function refreshTransactions(){

fetch("{{ route('admin.wallet.liveTransactions',$wallet->id) }}")

.then(res=>res.text())

.then(html=>{
document.getElementById('txnBody').innerHTML = html;
});

}

setInterval(refreshTransactions,4000);



/* HEATMAP */

var heatmapInstance = h337.create({

container: document.querySelector('#heatmap')

});

heatmapInstance.setData({

max:10,

data:[
{x:10,y:20,value:5},
{x:50,y:80,value:7},
{x:120,y:60,value:9}
]

});

</script>

@endsection
