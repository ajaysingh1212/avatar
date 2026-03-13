<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\License;
use App\Models\LicenseTransfer;
use Carbon\Carbon;

class LicenseTransferController extends Controller
{

    public function create()
    {

        $roles = \App\Models\Role::all();

        $licenses = License::where('status','active')
            ->where('is_used',0)
            ->whereNull('user_id')
            ->get();

        return view('admin.license_transfer.create',
            compact('roles','licenses'));

    }



    public function store(Request $request)
    {

        $request->validate([

            'user_id'=>'required',

            'license_ids'=>'required|array'

        ]);

        foreach($request->license_ids as $licenseId){

            $license = License::findOrFail($licenseId);

            $license->update([

                'user_id'=>$request->user_id

            ]);

            LicenseTransfer::create([

                'license_id'=>$license->id,

                'from_user_id'=>auth()->id(),

                'to_user_id'=>$request->user_id,

                'transferred_at'=>Carbon::now()

            ]);

        }

        return redirect()
            ->route('admin.license-stock.index')
            ->with('success','Licenses transferred successfully');

    }

}
