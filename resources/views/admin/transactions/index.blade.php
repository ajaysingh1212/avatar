@extends('layouts.admin')

@section('content')

<div class="card">

    <div class="card-header">
        <h3>All Transactions</h3>
    </div>

    <div class="card-body">

        {{-- FILTERS --}}
        <form method="GET" class="mb-3">
            <div class="row">

                <div class="col-md-3">
                    <select name="status" class="form-control">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
                        <option value="approved" {{ request('status')=='approved'?'selected':'' }}>Approved</option>
                        <option value="rejected" {{ request('status')=='rejected'?'selected':'' }}>Rejected</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                </div>

                <div class="col-md-3">
                    <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                </div>

                <div class="col-md-3">
                    <button class="btn btn-primary">Filter</button>
                    <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">Reset</a>
                </div>

            </div>
        </form>


        {{-- TABLE --}}
        <table class="table table-bordered table-striped" id="txnTable">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Email</th>
                    <th>Wallet</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th width="200">Action</th>
                </tr>
            </thead>

            <tbody>

                @foreach($transactions as $txn)

                <tr id="row-{{ $txn->id }}">

                    <td>{{ $txn->id }}</td>
                    <td>{{ $txn->wallet->user->name ?? '-' }}</td>
                    <td>{{ $txn->wallet->user->email ?? '-' }}</td>
                    <td>{{ $txn->wallet->wallet_number ?? '-' }}</td>
                    <td>₹ {{ number_format($txn->amount,2) }}</td>

                    <td id="status-{{ $txn->id }}">
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

                    <td>

                        @if($txn->status=='pending')

                        <button class="btn btn-success btn-sm approveBtn" data-id="{{ $txn->id }}">
                            <i class="fas fa-check"></i>
                        </button>

                        <button class="btn btn-danger btn-sm rejectBtn" data-id="{{ $txn->id }}">
                            <i class="fas fa-times"></i>
                        </button>

                        <button class="btn btn-warning btn-sm holdBtn" data-id="{{ $txn->id }}">
                            <i class="fas fa-pause"></i>
                        </button>

                        @endif

                        <a href="{{ route('admin.transactions.show',$txn->id) }}"
                           class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>

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

    $('#txnTable').DataTable({
        pageLength:50,
        dom:'Bfrtip',
        buttons:['copy','csv','excel','pdf','print']
    });

});


// ✅ APPROVE
$('.approveBtn').click(function(){

    let id = $(this).data('id');

    Swal.fire({
        title:'Approve transaction?',
        icon:'question',
        showCancelButton:true
    }).then((result)=>{

        if(result.isConfirmed){

            $.ajax({
                url: "{{ url('admin/transactions/approve') }}/"+id,
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },

                success: function(res){

                    $('#status-'+id).html('<span class="badge badge-success">Approved</span>');
                    $('#row-'+id+' .approveBtn').remove();
                    $('#row-'+id+' .rejectBtn').remove();
                    $('#row-'+id+' .holdBtn').remove();

                    Swal.fire('Success', res.message, 'success');
                },

                error: function(err){

                    let msg = err.responseJSON?.message || 'Error occurred';

                    Swal.fire('Error', msg, 'error');
                }
            });

        }

    });

});


// ✅ REJECT
$('.rejectBtn').click(function(){

    let id = $(this).data('id');

    Swal.fire({
        title:'Reject transaction?',
        icon:'warning',
        showCancelButton:true
    }).then((result)=>{

        if(result.isConfirmed){

            $.ajax({
                url: "{{ url('admin/transactions/reject') }}/"+id,
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },

                success: function(res){

                    $('#status-'+id).html('<span class="badge badge-danger">Rejected</span>');
                    $('#row-'+id+' .approveBtn').remove();
                    $('#row-'+id+' .rejectBtn').remove();
                    $('#row-'+id+' .holdBtn').remove();

                    Swal.fire('Rejected', res.message, 'success');
                },

                error: function(err){

                    let msg = err.responseJSON?.message || 'Error occurred';

                    Swal.fire('Error', msg, 'error');
                }
            });

        }

    });

});


// ✅ HOLD
$('.holdBtn').click(function(){

    let id = $(this).data('id');

    Swal.fire({
        title:'Hold transaction?',
        icon:'info',
        showCancelButton:true
    }).then((result)=>{

        if(result.isConfirmed){

            $.ajax({
                url: "{{ url('admin/transactions/hold') }}/"+id,
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },

                success: function(res){

                    $('#status-'+id).html('<span class="badge badge-info">Hold</span>');
                    $('#row-'+id+' .approveBtn').remove();
                    $('#row-'+id+' .rejectBtn').remove();
                    $('#row-'+id+' .holdBtn').remove();

                    Swal.fire('Hold', res.message, 'success');
                },

                error: function(err){

                    let msg = err.responseJSON?.message || 'Error occurred';

                    Swal.fire('Error', msg, 'error');
                }
            });

        }

    });

});

</script>

@endsection
