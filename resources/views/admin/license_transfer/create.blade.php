@extends('layouts.admin')

@section('title','Create Stock Transfer')

@section('content')

<div class="card shadow-lg">

<div class="card-header">
<h3>Create Stock Transfer</h3>
</div>

<div class="card-body">

<form method="POST" action="{{ route('admin.license-transfer.store') }}">
@csrf

<div class="row">

<div class="col-md-4">
<label>Transfer Date</label>
<input type="date" name="transfer_date" class="form-control"
value="{{ date('Y-m-d') }}">
</div>

<div class="col-md-4">
<label>Reseller Type</label>

<select id="roleSelect" class="form-control">

<option value="">Please select</option>

@foreach($roles as $role)

<option value="{{ $role->slug }}">
{{ $role->name }}
</option>

@endforeach

</select>

</div>

<div class="col-md-4">

<label>Reseller</label>

<select name="user_id" id="userSelect" class="form-control">

<option>Please select</option>

</select>

</div>

</div>

<hr>

<div class="row">

<div class="col-md-6">

<label>Select License *</label>

<select id="productSelect" class="form-control">

<option value="">Please select</option>

@foreach($licenses as $license)

<option
value="{{ $license->id }}"

data-key="{{ $license->license_key }}"
data-product="{{ $license->product_name }}"
data-plan="{{ $license->plan_name }}"
data-devices="{{ $license->max_devices }}"
data-validity="{{ $license->validity_days }}"
data-issued="{{ $license->issued_at }}"
data-expiry="{{ $license->expires_at }}"

>

{{ $license->license_key }} ({{ $license->product_name }})

</option>

@endforeach

</select>

</div>

</div>


<div id="productDetails" style="display:none">

<hr>

<div class="row">

<div class="col-md-3">
<label>Product</label>
<input type="text" id="productName" class="form-control" readonly>
</div>

<div class="col-md-3">
<label>Plan</label>
<input type="text" id="planName" class="form-control" readonly>
</div>

<div class="col-md-3">
<label>Devices</label>
<input type="text" id="devices" class="form-control" readonly>
</div>

<div class="col-md-3">
<label>Validity (Days)</label>
<input type="text" id="validity" class="form-control" readonly>
</div>

</div>


<div class="row mt-3">

<div class="col-md-3">
<label>Issued</label>
<input type="text" id="issued" class="form-control" readonly>
</div>

<div class="col-md-3">
<label>Expiry</label>
<input type="text" id="expiry" class="form-control" readonly>
</div>

<div class="col-md-2">
<label>Price</label>
<input type="number" id="price" class="form-control">
</div>

<div class="col-md-2">

<label>Discount Type</label>

<select id="discountType" class="form-control">

<option value="value">Value</option>
<option value="percent">%</option>

</select>

</div>

<div class="col-md-2">
<label>Discount</label>
<input type="number" id="discount" class="form-control" value="0">
</div>

</div>


<button type="button"
class="btn btn-primary mt-3"
id="addProductBtn">

Add Product

</button>

</div>

<hr>

<h5>Product Summary</h5>

<table class="table table-bordered" id="summaryTable">

<thead>

<tr>

<th>License</th>
<th>Product</th>
<th>Plan</th>
<th>Devices</th>
<th>Price</th>
<th>Discount</th>
<th>Base Price</th>
<th>CGST</th>
<th>SGST</th>
<th>Total</th>
<th>Action</th>

</tr>

</thead>

<tbody></tbody>

</table>

<button class="btn btn-danger mt-3">Save Transfer</button>

</form>

</div>
</div>

@endsection


<style>

.form-control,
.form-control:focus,
.form-control[readonly],
.form-control:disabled {

background-color:#0f1c2e !important;
color:#ffffff !important;
border:1px solid #2c3e50 !important;

}

</style>


@section('scripts')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

$(document).ready(function(){

let rowIndex = 0;

$('#roleSelect').change(function(){

let role = $(this).val()

$.get('/admin/get-users-by-role/'+role,function(res){

$('#userSelect').html(res)

})

})


$('#productSelect').change(function(){

let option = $(this).find(':selected')

$('#productDetails').show()

$('#productName').val(option.data('product'))
$('#planName').val(option.data('plan'))
$('#devices').val(option.data('devices'))
$('#validity').val(option.data('validity'))
$('#issued').val(option.data('issued'))
$('#expiry').val(option.data('expiry'))

})


$('#addProductBtn').click(function(){

let option = $('#productSelect').find(':selected')

let id = option.val()

let price = parseFloat($('#price').val())

let discount = parseFloat($('#discount').val())

let type = $('#discountType').val()

if(type=='percent'){
discount = price * discount / 100
}

let base = price - discount

let cgst = base * 0.09

let sgst = base * 0.09

let total = base + cgst + sgst


let row =

`<tr>

<td>

${option.data('key')}

<input type="hidden" name="items[${rowIndex}][license_id]" value="${id}">

</td>

<td>${option.data('product')}</td>

<td>${option.data('plan')}</td>

<td>${option.data('devices')}</td>

<td>

${price}

<input type="hidden" name="items[${rowIndex}][price]" value="${price}">

</td>

<td>

${discount.toFixed(2)}

<input type="hidden" name="items[${rowIndex}][discount]" value="${discount}">

</td>

<td>

${base.toFixed(2)}

<input type="hidden" name="items[${rowIndex}][base_price]" value="${base}">

</td>

<td>

${cgst.toFixed(2)}

<input type="hidden" name="items[${rowIndex}][cgst]" value="${cgst}">

</td>

<td>

${sgst.toFixed(2)}

<input type="hidden" name="items[${rowIndex}][sgst]" value="${sgst}">

</td>

<td>

${total.toFixed(2)}

<input type="hidden" name="items[${rowIndex}][total]" value="${total}">

</td>

<td>

<button type="button" class="btn btn-danger remove">
Remove
</button>

</td>

</tr>`

$('#summaryTable tbody').append(row)

$('#productSelect option:selected').remove()

$('#productDetails').hide()

rowIndex++

})


$(document).on('click','.remove',function(){

$(this).closest('tr').remove()

})

})

</script>

@endsection
