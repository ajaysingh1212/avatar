<?Php

namespace App\Services;

use App\Models\Alert;

class AlertService
{
    public static function engine($data)
    {
        if($data['ignition']){

            Alert::create([
                'imei'=>$data['imei'],
                'type'=>'engine_on',
                'message'=>'Engine Started'
            ]);

        }else{

            Alert::create([
                'imei'=>$data['imei'],
                'type'=>'engine_off',
                'message'=>'Engine Stopped'
            ]);
        }
    }
}
