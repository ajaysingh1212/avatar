<?php

namespace App\Models;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class DeviceLocation extends BaseModel
{
    protected $fillable = [

        'imei',
        'tracked_at',
        'latitude',
        'longitude',
        'speed',
        'course',
        'ignition',
        'gps_valid'

    ];
}
