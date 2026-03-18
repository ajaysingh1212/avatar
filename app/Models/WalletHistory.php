<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletHistory extends Model
{

    protected $fillable = [

        'wallet_id',
        'action',
        'description',
        'performed_by',
        'module',
        'ip'
    ];


    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

}
