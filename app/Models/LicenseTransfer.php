<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LicenseTransfer extends Model
{

    protected $fillable = [

        'from_user_id',
        'to_user_id',
        'total_licenses',
        'created_by',
        'notes'

    ];

    public function items()
    {
        return $this->hasMany(LicenseTransferItem::class,'transfer_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'to_user_id');
    }
}
