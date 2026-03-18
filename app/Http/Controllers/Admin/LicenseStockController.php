<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\License;
use Illuminate\Support\Facades\Auth;

class LicenseStockController extends Controller
{

public function index()
{

$user = Auth::user();

/*
|--------------------------------------------------------------------------
| Admin / Super Admin
|--------------------------------------------------------------------------
*/

if($user->hasRole('admin') || $user->hasRole('super-admin')){

$stocks = License::where('status','active')
->where('is_used',0)
->whereNull('user_id')
->latest()
->paginate(20);

}else{

/*
|--------------------------------------------------------------------------
| Normal User
|--------------------------------------------------------------------------
*/

$stocks = License::where('status','active')
->where('is_used',0)
->where('user_id',$user->id)
->latest()
->paginate(20);

}

return view('admin.license_stock.index',compact('stocks'));

}



public function show($id)
{

$stock = License::findOrFail($id);

return view('admin.license_stock.show', compact('stock'));

}

}
