<?php
namespace App\Services;

use App\Models\Trip;

class TripService
{
    public static function detect($data)
    {
        $imei = $data['imei'];

        $trip = Trip::where('imei',$imei)
            ->whereNull('end_time')
            ->first();

        if($data['ignition'] && $data['speed'] > 5){

            if(!$trip){

                Trip::create([
                    'imei'=>$imei,
                    'start_time'=>$data['tracked_at']
                ]);
            }

        } else {

            if($trip){

                $trip->update([
                    'end_time'=>$data['tracked_at']
                ]);
            }
        }
    }
}
