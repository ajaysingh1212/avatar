<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\License;

class Stock extends BaseModel
{
    protected $fillable = [
        'user_id',
        'total_stock',
        'used_stock',
        'available_stock'
    ];

    /**
     * Stock belongs to a user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Licenses assigned to this user's stock
     */
    public function licenses()
    {
        return $this->hasMany(License::class, 'user_id', 'user_id');
    }

    /**
     * Get only active licenses
     */
    public function activeLicenses()
    {
        return $this->hasMany(License::class, 'user_id', 'user_id')
                    ->where('status', 'active');
    }

    /**
     * Get available licenses (not used)
     */
    public function availableLicenses()
    {
        return $this->hasMany(License::class, 'user_id', 'user_id')
                    ->where('status', 'active')
                    ->where('is_used', 0);
    }
}
