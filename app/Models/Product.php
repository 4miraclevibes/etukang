<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'merchant_id',
        'name',
        'description',
        'price',
        'status',
        'image',
        'sertifikasi',
    ];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function transactionDetail()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
