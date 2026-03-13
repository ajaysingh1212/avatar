<?php

namespace App\Services;

use App\Models\Geofence;
use App\Models\Alert;

class GeofenceService
{
    public static function check($data)
    {
        $fences = Geofence::all();

        foreach($fences as $f){

            $distance = self::distance(
                $data['latitude'],
                $data['longitude'],
                $f->latitude,
                $f->longitude
            );

            if($distance < $f->radius){

                Alert::create([
                    'imei'=>$data['imei'],
                    'type'=>'geofence',
                    'message'=>"Entered ".$f->name
                ]);
            }
        }
    }

    private static function distance($lat1,$lon1,$lat2,$lon2)
    {
        $theta = $lon1 - $lon2;

        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            cos(deg2rad($theta));

        return acos($dist) * 6371 * 1000;
    }
}