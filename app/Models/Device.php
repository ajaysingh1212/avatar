<?php

namespace App\Models;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Device extends BaseModel
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
