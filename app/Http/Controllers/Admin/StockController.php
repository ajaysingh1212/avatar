<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\License;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{

    public function index()
    {

        $user = Auth::user();

        $stocks = License::where('status','active')
            ->where('is_used',0)
            ->where('user_id',$user->id)
            ->latest()
            ->paginate(20);

        $totalStock = License::where('user_id',$user->id)->count();

        $availableStock = License::where('status','active')
            ->where('is_used',0)
            ->where('user_id',$user->id)
            ->count();

        $usedStock = License::where('user_id',$user->id)
            ->where('is_used',1)
            ->count();

        return view('admin.stocks.index',compact(
            'stocks',
            'totalStock',
            'availableStock',
            'usedStock'
        ));

    }

}
