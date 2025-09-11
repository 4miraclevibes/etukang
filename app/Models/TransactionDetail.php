<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $fillable = [
        'cart_id',
        'transaction_id',
        'product_id',
        'quantity',
        'price',
        'status',
        'ulasan',
        'rating',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function user()
    {
        return $this->hasOneThrough(User::class, Transaction::class, 'id', 'id', 'transaction_id', 'user_id');
    }
}
