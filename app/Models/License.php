<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
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
        'notes'

    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
