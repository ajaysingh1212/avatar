<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends BaseModel
{
    use HasFactory;

    protected $fillable = [

        'license_key',
        'user_id',
        'product_name',
        'plan_name',
        'max_devices',
        'validity_days',
        'issued_at',
        'expires_at',
        'status',
        'is_used',
        'purchase_reference',
        'notes',
        'transferred_by',
        'transferred_at'

    ];

    protected $casts = [

        'issued_at' => 'datetime',
        'expires_at' => 'datetime'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    public function isAvailable()
    {
        return $this->status == 'active'
            && $this->is_used == 0
            && $this->user_id == null;
    }

}
