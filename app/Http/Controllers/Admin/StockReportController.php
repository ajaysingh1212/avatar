<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\License;
use App\Models\LicenseTransfer;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class StockReportController extends Controller
{

public function index()
{

$roles = Role::all();

$users = [];

$reports = [];

return view('admin.stock_report.index',
compact('roles','users','reports'));

}



public function getUsersByRole($role)
{

$users = User::whereHas('roles',function($q) use ($role){

$q->where('slug',$role);

})->get();

$options='<option value="">Select User</option>';

foreach($users as $user){

$options .= '<option value="'.$user->id.'">'.$user->name.'</option>';

}

return $options;

}



public function report(Request $request)
{

$query = LicenseTransfer::with(['items.license','user']);

if($request->user_id){

$query->where('to_user_id',$request->user_id);

}

if($request->from_date){

$query->whereDate('created_at','>=',$request->from_date);

}

if($request->to_date){

$query->whereDate('created_at','<=',$request->to_date);

}

$reports = $query->latest()->get();



$currentStocks = License::where('user_id',$request->user_id)
->where('is_used',0)
->get();



$roles = Role::all();

return view('admin.stock_report.index',compact(
'reports',
'roles',
'currentStocks'
));

}

}
