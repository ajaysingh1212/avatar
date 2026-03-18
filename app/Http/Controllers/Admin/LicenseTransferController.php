<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\License;
use App\Models\LicenseTransfer;
use App\Models\LicenseTransferItem;
use App\Models\Role;
use App\Models\User;
use App\Models\Stock;
use Illuminate\Http\Request;
use DB;

class LicenseTransferController extends Controller
{

public function index()
{

$transfers = LicenseTransfer::with(['items.license','user'])
->latest()
->paginate(20);

return view('admin.license_transfer.index',compact('transfers'));

}



public function create()
{

$licenses = License::where('status','active')
->where('is_used',0)
->whereNull('user_id')
->get();

$roles = Role::all();
$users = User::all();

return view('admin.license_transfer.create',compact('licenses','users','roles'));

}



public function store(Request $request)
{

$request->validate([
'user_id'=>'required|exists:users,id',
'items'=>'required|array'
]);

DB::beginTransaction();

try{

$totalLicenses = count($request->items);

$transfer = LicenseTransfer::create([

'from_user_id'=>null,
'to_user_id'=>$request->user_id,
'total_licenses'=>$totalLicenses,
'created_by'=>auth()->id(),
'notes'=>$request->notes

]);

foreach($request->items as $item){

$license = License::where('id',$item['license_id'])
->where('status','active')
->where('is_used',0)
->whereNull('user_id')
->firstOrFail();

LicenseTransferItem::create([

'transfer_id'=>$transfer->id,
'license_id'=>$item['license_id'],
'price'=>$item['price'],
'discount'=>$item['discount'],
'base_price'=>$item['base_price'],
'cgst'=>$item['cgst'],
'sgst'=>$item['sgst'],
'total'=>$item['total']

]);

$license->update([

'user_id'=>$request->user_id,
'transfer_id'=>$transfer->id,
'transferred_by'=>auth()->id(),
'transferred_at'=>now()

]);

}



$count = $totalLicenses;



/*
|--------------------------------------------------------------------------
| Update Admin Stock
|--------------------------------------------------------------------------
*/

$adminStock = Stock::whereNull('user_id')->first();

if($adminStock){

$adminStock->decrement('available_stock',$count);
$adminStock->increment('used_stock',$count);

}



/*
|--------------------------------------------------------------------------
| Update User Stock
|--------------------------------------------------------------------------
*/

$userStock = Stock::firstOrCreate(

['user_id'=>$request->user_id],

[
'total_stock'=>0,
'used_stock'=>0,
'available_stock'=>0
]

);

$userStock->increment('total_stock',$count);
$userStock->increment('available_stock',$count);



DB::commit();

return redirect()
->route('admin.license-transfer.index')
->with('success','Licenses transferred successfully');

}

catch(\Exception $e){

DB::rollback();

return back()->with('error',$e->getMessage());

}

}



public function show($id)
{

$transfer = LicenseTransfer::with(['items.license','user'])
->findOrFail($id);

return view('admin.license_transfer.show',compact('transfer'));

}



public function edit($id)
{

$transfer = LicenseTransfer::with(['items.license','user'])
->findOrFail($id);

$roles = Role::all();
$users = User::all();

return view('admin.license_transfer.edit',
compact('transfer','roles','users'));

}



public function update(Request $request,$id)
{

$transfer = LicenseTransfer::findOrFail($id);

$transfer->update([

'to_user_id'=>$request->user_id,
'notes'=>$request->notes

]);

return redirect()
->route('admin.license-transfer.index')
->with('success','Transfer updated successfully');

}



public function destroy($id)
{

$transfer = LicenseTransfer::with('items.license')->findOrFail($id);

DB::beginTransaction();

try{

foreach($transfer->items as $item){

$item->license->update([

'user_id'=>null,
'transfer_id'=>null

]);

}

LicenseTransferItem::where('transfer_id',$transfer->id)->delete();

$transfer->delete();

DB::commit();

return back()->with('success','Transfer deleted');

}

catch(\Exception $e){

DB::rollback();

return back()->with('error',$e->getMessage());

}

}



public function getUsersByRole($role)
{

$users = User::whereHas('roles',function($q) use ($role){

$q->where('slug',$role);

})->get();

$options='<option value="">Please select</option>';

foreach($users as $user){

$options .= '<option value="'.$user->id.'">'.$user->name.' ('.$user->email.')</option>';

}

return $options;

}

}
