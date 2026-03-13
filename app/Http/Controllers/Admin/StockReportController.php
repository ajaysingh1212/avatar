<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\License;

class StockReportController extends Controller
{

    public function index()
    {

        $reports = License::with('user')
            ->latest()
            ->paginate(30);

        return view('admin.stock_report.index',compact('reports'));

    }

}
