<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LicenseTransfer extends Model
{

    protected $fillable = [

        'license_id',
        'from_user_id',
        'to_user_id',
        'transferred_at'

    ];

    public function license()
    {
        return $this->belongsTo(License::class);
    }

    public function fromUser()
    {
        return $this->belongsTo(User::class,'from_user_id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class,'to_user_id');
    }

}
