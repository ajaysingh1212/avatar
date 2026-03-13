<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alert;

class AlertController extends Controller
{

    public function index()
    {

        $alerts = Alert::latest()->paginate(50);

        return view('admin.alerts.index',compact('alerts'));
    }

}
