<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{

    protected $fillable = [

        'user_id',
        'total_stock',
        'used_stock',
        'available_stock'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
