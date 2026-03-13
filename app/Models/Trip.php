<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = [

        'imei',
        'start_time',
        'end_time',
        'start_lat',
        'start_lng',
        'end_lat',
        'end_lng'

    ];
}
