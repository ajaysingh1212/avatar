<?php

namespace App\Models;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Geofence extends BaseModel
{
    protected $fillable = [

        'name',
        'lat',
        'lng',
        'radius'

    ];
}
