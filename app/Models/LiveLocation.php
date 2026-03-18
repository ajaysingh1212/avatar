<?php

namespace App\Models;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class LiveLocation extends BaseModel
{
    protected $fillable = [

        'imei',
        'latitude',
        'longitude',
        'speed',
        'course',
        'ignition',
        'gps_valid',
        'tracked_at'

    ];
}
