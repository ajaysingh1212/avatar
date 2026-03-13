<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\License;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class LicenseController extends Controller
{

    public function index()
    {
        $licenses = License::latest()->paginate(20);

        return view('admin.licenses.index', compact('licenses'));
    }


    public function create()
    {
        return view('admin.licenses.create');
    }


    public function store(Request $request)
    {

        $request->validate([
            'quantity' => 'required|integer|min:1|max:10000',
            'product_name' => 'required|string',
            'plan_name' => 'required|string',
            'validity_days' => 'required|integer',
        ]);

        $quantity = (int) $request->quantity;

        $adminId = Auth::id();

        for ($i = 0; $i < $quantity; $i++) {

            License::create([

                'license_key' => $this->generateLicenseKey(),

                'product_name' => $request->product_name,

                'plan_name' => $request->plan_name,

                'max_devices' => $request->max_devices ?? 1,

                'validity_days' => (int) $request->validity_days,

                'issued_at' => null,

                'expires_at' => null,

                'status' => 'active',

                'is_used' => false,

                // IMPORTANT → license creator owns stock
                'user_id' => $adminId,

                'notes' => $request->notes

            ]);

        }

        /*
        |--------------------------------------------------------------------------
        | Update Current Stocks
        |--------------------------------------------------------------------------
        */

        $stock = Stock::firstOrCreate(
            ['user_id' => $adminId],
            [
                'total_stock' => 0,
                'used_stock' => 0,
                'available_stock' => 0
            ]
        );

        $stock->increment('total_stock', $quantity);
        $stock->increment('available_stock', $quantity);


        return redirect()
            ->route('admin.licenses.index')
            ->with('success','Licenses Generated & Stock Updated');

    }


    public function show($id)
    {
        $license = License::findOrFail($id);

        return view('admin.licenses.show', compact('license'));
    }


    public function edit($id)
    {
        $license = License::findOrFail($id);

        return view('admin.licenses.edit', compact('license'));
    }


    public function update(Request $request, $id)
    {

        $license = License::findOrFail($id);

        $request->validate([
            'product_name' => 'required',
            'plan_name' => 'required',
            'validity_days' => 'required|integer'
        ]);

        $license->update([

            'product_name' => $request->product_name,

            'plan_name' => $request->plan_name,

            'max_devices' => $request->max_devices,

            'validity_days' => (int) $request->validity_days,

            'status' => $request->status,

            'notes' => $request->notes

        ]);

        return redirect()
            ->route('admin.licenses.index')
            ->with('success','License Updated');

    }


    public function destroy($id)
    {

        $license = License::findOrFail($id);

        $license->delete();

        return back()->with('success','License Deleted');

    }


    /*
    |--------------------------------------------------------------------------
    | License Activation
    |--------------------------------------------------------------------------
    */

    public function activate($licenseKey)
    {

        $license = License::where('license_key',$licenseKey)->firstOrFail();

        if($license->is_used){

            return response()->json([
                'status'=>'error',
                'message'=>'License already used'
            ]);

        }

        $issued = Carbon::now();

        $expires = Carbon::now()->addDays((int)$license->validity_days);

        $license->update([

            'issued_at' => $issued,

            'expires_at' => $expires,

            'status' => 'active',

            'is_used' => true

        ]);

        /*
        |--------------------------------------------------------------------------
        | Update Used Stock
        |--------------------------------------------------------------------------
        */

        if($license->user_id){

            $stock = Stock::where('user_id',$license->user_id)->first();

            if($stock){

                $stock->increment('used_stock',1);
                $stock->decrement('available_stock',1);

            }

        }

        return response()->json([
            'status'=>'success',
            'expires_at'=>$expires
        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | License Key Generator
    |--------------------------------------------------------------------------
    */

    private function generateLicenseKey()
    {

        return strtoupper(Str::random(4)).'-'.
               strtoupper(Str::random(4)).'-'.
               strtoupper(Str::random(4)).'-'.
               strtoupper(Str::random(4));

    }

}
