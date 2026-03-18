<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{

    protected $fillable = [

        'wallet_id',
        'transaction_id',

        'type',
        'amount',

        'before_balance',
        'after_balance',

        'status',
        'remarks',

        'approved_by',
        'approved_at',

        'created_by_id',
        'updated_by_id',

        'created_ip',
        'updated_ip',

        'is_locked',
        'lock_token',
        'locked_at',

        'rollback_status',

        'device',
        'user_agent',

        'reference_id',
        'currency'
    ];



    protected $casts = [

        'amount' => 'decimal:2',

        'before_balance' => 'decimal:2',
        'after_balance' => 'decimal:2',

        'approved_at' => 'datetime',
        'locked_at' => 'datetime',

        'rollback_status' => 'boolean',
        'is_locked' => 'boolean'
    ];



    /* ===============================
       RELATION
    =============================== */

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

}
