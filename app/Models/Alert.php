<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $fillable = [

        'imei',
        'type',
        'latitude',
        'longitude',
        'time'

    ];
}
