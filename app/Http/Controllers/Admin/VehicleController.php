<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeviceLocation;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VehicleController extends Controller
{

    /* =========================
       MAP PAGE
    ========================= */

    public function map()
    {

        $settings = Setting::first();

        $devices = DeviceLocation::select(
                'imei',
                'latitude',
                'longitude',
                'speed',
                'ignition',
                'tracked_at'
            )
            ->whereIn('id', function($q){

                $q->select(DB::raw('MAX(id)'))
                  ->from('device_locations')
                  ->groupBy('imei');

            })
            ->get();

        $devices = $devices->map(function($d){

            $seconds = now()->timestamp - Carbon::parse($d->tracked_at)->timestamp;

            $d->status = $seconds <= 60 ? 'online' : 'offline';

            return $d;

        });

        $devices = $devices->sortByDesc(function($d){
            return $d->status === 'online';
        });

        return view('admin.vehicles.map',compact('devices','settings'));

    }


    /* =========================
       DEVICE HISTORY
    ========================= */

    public function history(Request $request)
    {

        $history = DeviceLocation::where('imei',$request->imei)
            ->whereBetween('tracked_at',[$request->from,$request->to])
            ->orderBy('tracked_at')
            ->get([
                'latitude',
                'longitude',
                'speed',
                'ignition',
                'tracked_at'
            ]);

        return response()->json($history);

    }

}
