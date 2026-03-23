@extends('layouts.admin')

@section('content')

<div class="card">

<div class="card-header">

<h3 class="card-title">Wallets</h3>

@if(session('success'))
<div class="alert alert-success mt-2">
{{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger mt-2">
{{ session('error') }}
</div>
@endif

<a href="{{ route('admin.wallets.create') }}" class="btn btn-primary float-right">
<i class="fas fa-plus"></i> Create Wallet
</a>

</div>

<div class="card-body">

<table class="table table-bordered table-striped" id="walletTable">

<thead>

<tr>
<th>ID</th>
<th>User</th>
<th>Wallet No</th>
<th>Balance</th>
<th>Status</th>
<th>Frozen</th>
<th width="280">Actions</th>
</tr>

</thead>

<tbody>

@foreach($wallets as $wallet)

<tr>

<td>{{ $wallet->id }}</td>

<td>{{ $wallet->user->name ?? '' }}</td>

<td>{{ $wallet->wallet_number }}</td>

<td>₹ {{ number_format($wallet->balance,2) }}</td>

<td>

@if($wallet->status=='approved')
<span class="badge badge-success">Approved</span>

@elseif($wallet->status=='pending')
<span class="badge badge-warning">Pending</span>

@else
<span class="badge badge-danger">Rejected</span>
@endif

</td>


<td>

@if($wallet->is_frozen)
<span class="badge badge-danger">
<i class="fas fa-lock"></i> Frozen
</span>
@else
<span class="badge badge-success">
<i class="fas fa-unlock"></i> Active
</span>
@endif

</td>


<td class="text-center">

<a href="{{ route('admin.wallets.show',$wallet->id) }}"
class="btn btn-info btn-sm action-btn"
title="View Wallet">

<i class="fas fa-eye"></i>

</a>
<button class="btn btn-primary btn-sm addFundBtn"
    data-id="{{ $wallet->id }}"
    data-wallet="{{ $wallet->wallet_number }}"
    title="Add Fund">

    <i class="fas fa-plus-circle"></i>
</button>

<a href="{{ route('admin.wallets.edit',$wallet->id) }}"
class="btn btn-warning btn-sm action-btn"
title="Edit Wallet">

<i class="fas fa-edit"></i>

</a>


<a href="{{ route('admin.wallets.history',$wallet->id) }}"
class="btn btn-secondary btn-sm action-btn"
title="Wallet History">

<i class="fas fa-history"></i>

</a>


<a href="{{ route('admin.transactions.index',['wallet'=>$wallet->id]) }}"
class="btn btn-dark btn-sm action-btn"
title="Transactions">

<i class="fas fa-exchange-alt"></i>

</a>


{{-- APPROVE WALLET --}}

@if($wallet->status=='pending')

<form action="{{ route('admin.wallets.approve',$wallet->id) }}"
method="POST"
style="display:inline-block">

@csrf

<button class="btn btn-success btn-sm action-btn approveWallet">

<i class="fas fa-check"></i>

</button>

</form>

@endif


{{-- REJECT WALLET --}}

@if($wallet->status=='pending')

<form action="{{ route('admin.wallets.reject',$wallet->id) }}"
method="POST"
style="display:inline-block">

@csrf

<button class="btn btn-danger btn-sm action-btn rejectWallet">

<i class="fas fa-times"></i>

</button>

</form>

@endif


{{-- FREEZE WALLET --}}

@if(!$wallet->is_frozen)

<form action="{{ route('admin.wallets.freeze',$wallet->id) }}"
method="POST"
style="display:inline-block">

@csrf

<button class="btn btn-danger btn-sm action-btn freezeWallet"
title="Freeze Wallet">

<i class="fas fa-lock"></i>

</button>

</form>

@endif


{{-- UNFREEZE WALLET --}}

@if($wallet->is_frozen)

<form action="{{ route('admin.wallets.unfreeze',$wallet->id) }}"
method="POST"
style="display:inline-block">

@csrf

<button class="btn btn-success btn-sm action-btn unfreezeWallet"
title="Unfreeze Wallet">

<i class="fas fa-lock-open"></i>

</button>

</form>

@endif

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>
<div class="modal fade" id="addFundModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content custom-modal">

            <div class="modal-header custom-header">
                <h5 class="modal-title">
                    <i class="fas fa-wallet"></i> Add Fund
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <form id="addFundForm">

                    @csrf

                    <input type="hidden" name="wallet_id" id="wallet_id">

                    <div class="form-group">
                        <label>Wallet</label>
                        <input type="text" id="wallet_no" class="form-control custom-input" readonly>
                    </div>

                    <div class="form-group">
                        <label>Amount</label>
                        <input type="number" name="amount" class="form-control custom-input" placeholder="Enter amount">
                    </div>

                    <button class="btn btn-gradient btn-block mt-3">
                        <i class="fas fa-plus-circle"></i> Add Fund
                    </button>

                </form>

            </div>

        </div>
    </div>
</div>
<style>
    /* Modal Background */
.custom-modal {
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0px 10px 30px rgba(0,0,0,0.3);
    border: none;
}

/* Header Gradient */
.custom-header {
    background: linear-gradient(135deg, #4facfe, #00f2fe);
    color: white;
    border-bottom: none;
}

/* Input Styling */
.custom-input {
    border-radius: 10px;
    padding: 10px;
    border: 1px solid #ddd;
    transition: 0.3s;
}

.custom-input:focus {
    border-color: #4facfe;
    box-shadow: 0px 0px 8px rgba(79,172,254,0.5);
}

/* Button Gradient */
.btn-gradient {
    background: linear-gradient(135deg, #00c853, #64dd17);
    color: white;
    border: none;
    border-radius: 10px;
    padding: 10px;
    transition: 0.3s;
}

.btn-gradient:hover {
    transform: scale(1.05);
    box-shadow: 0px 5px 15px rgba(0,200,83,0.4);
}

/* Label styling */
.modal-body label {
    font-weight: 600;
    margin-bottom: 5px;
}
</style>
@endsection



@section('scripts')

<script>

$(document).ready(function(){

$('#walletTable').DataTable({

pageLength:50,

lengthMenu:[
[10,25,50,100,500],
[10,25,50,100,500]
],

dom:'Bfrtip',

buttons:[

{extend:'copy',className:'btn btn-secondary btn-sm'},
{extend:'csv',className:'btn btn-success btn-sm'},
{extend:'excel',className:'btn btn-success btn-sm'},
{extend:'pdf',className:'btn btn-danger btn-sm'},
{extend:'print',className:'btn btn-info btn-sm'},
{extend:'colvis',className:'btn btn-warning btn-sm'}

]

});

});



/* APPROVE */

$('.approveWallet').click(function(e){

e.preventDefault();

let form = $(this).closest('form');

Swal.fire({
title:'Approve Wallet?',
icon:'question',
showCancelButton:true,
confirmButtonText:'Yes Approve'
}).then((result)=>{
if(result.isConfirmed){
form.submit();
}
});

});



/* REJECT */

$('.rejectWallet').click(function(e){

e.preventDefault();

let form = $(this).closest('form');

Swal.fire({
title:'Reject Wallet?',
icon:'warning',
showCancelButton:true,
confirmButtonText:'Yes Reject'
}).then((result)=>{
if(result.isConfirmed){
form.submit();
}
});

});


/* FREEZE */

$('.freezeWallet').click(function(e){

e.preventDefault();

let form = $(this).closest('form');

Swal.fire({
title:'Freeze Wallet?',
text:'User will not be able to transact',
icon:'warning',
showCancelButton:true,
confirmButtonText:'Freeze'
}).then((result)=>{
if(result.isConfirmed){
form.submit();
}
});

});


/* UNFREEZE */

$('.unfreezeWallet').click(function(e){

e.preventDefault();

let form = $(this).closest('form');

Swal.fire({
title:'Unfreeze Wallet?',
icon:'question',
showCancelButton:true,
confirmButtonText:'Unfreeze'
}).then((result)=>{
if(result.isConfirmed){
form.submit();
}
});

});


// OPEN MODAL
$('.addFundBtn').click(function(){

    let id = $(this).data('id');
    let wallet = $(this).data('wallet');

    $('#wallet_id').val(id);
    $('#wallet_no').val(wallet);

    $('#addFundModal').modal('show');

});


// SUBMIT FUND
$('#addFundForm').submit(function(e){

    e.preventDefault();

    $.ajax({
        url: "{{ url('admin/wallets/add-fund') }}",
        method: "POST",
        data: $(this).serialize(),

        success: function(res){

            $('#addFundModal').modal('hide');

            Swal.fire({
                icon:'success',
                title: res.message
            }).then(()=>{
                location.reload();
            });

        },

        error: function(err){

            let msg = err.responseJSON?.message || 'Something went wrong';

            Swal.fire({
                icon:'error',
                title: msg
            });

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
