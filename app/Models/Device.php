<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'imei'
    ];

    
    public function liveLocation()
    {
        return $this->hasOne(LiveLocation::class,'imei','imei');
    }

    public function locations()
    {
        return $this->hasMany(DeviceLocation::class,'imei','imei');
    }
}
