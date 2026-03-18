<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{

    protected $fillable = [

        'user_id',
        'wallet_number',
        'balance',
        'status',

        'approved_by',
        'approved_at',

        'created_by_id',
        'updated_by_id',

        'created_ip',
        'updated_ip',

        'is_frozen',
        'frozen_at',
        'frozen_by',

        'daily_limit',
        'monthly_limit',
        'single_txn_limit',

        'daily_used',
        'monthly_used',

        'fraud_flag',
        'fraud_score'
    ];



    protected $casts = [

        'balance' => 'decimal:2',

        'is_frozen' => 'boolean',
        'fraud_flag' => 'boolean',

        'approved_at' => 'datetime',
        'frozen_at' => 'datetime'
    ];



    /* ===============================
       RELATIONS
    =============================== */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function history()
    {
        return $this->hasMany(WalletHistory::class);
    }

}
