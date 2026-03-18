<?php

namespace App\Models;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Alert extends BaseModel
{
    protected $fillable = [

        'imei',
        'type',
        'latitude',
        'longitude',
        'time'

    ];
}
