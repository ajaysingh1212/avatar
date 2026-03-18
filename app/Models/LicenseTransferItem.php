<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LicenseTransferItem extends Model
{

    protected $fillable = [

        'transfer_id',
        'license_id',
        'price',
        'discount',
        'base_price',
        'cgst',
        'sgst',
        'total'

    ];
    public function license()
    {
    return $this->belongsTo(License::class);
    }
}
