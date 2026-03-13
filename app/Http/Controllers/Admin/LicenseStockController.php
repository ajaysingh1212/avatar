<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\License;

class LicenseStockController extends Controller
{

    public function index()
    {

        $stocks = License::where('status','active')
            ->where('is_used',0)
            ->whereNull('user_id')
            ->latest()
            ->paginate(20);

        return view('admin.license_stock.index',compact('stocks'));

    }

}
