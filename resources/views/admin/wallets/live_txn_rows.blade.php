@foreach($txns as $txn)

<tr>

<td>{{ $txn->id }}</td>

<td>{{ $txn->transaction_id }}</td>

<td>

@if($txn->type == 'credit')

<span class="badge badge-success">
<i class="fas fa-arrow-down"></i> Credit
</span>

@else

<span class="badge badge-danger">
<i class="fas fa-arrow-up"></i> Debit
</span>

@endif

</td>

<td>

₹ {{ number_format($txn->amount,2) }}

</td>

<td>

@if($txn->status == 'approved')

<span class="badge badge-success">
Approved
</span>

@elseif($txn->status == 'pending')

<span class="badge badge-warning">
Pending
</span>

@else

<span class="badge badge-danger">
Rejected
</span>

@endif

</td>

<td>

{{ $txn->created_at->diffForHumans() }}

</td>

</tr>

@endforeach
