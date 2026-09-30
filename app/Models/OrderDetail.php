<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetail extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'product_id',
        'quantity',
        'price',
        'subtotal',
        'order_id',
    ];

    public function products(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function orders(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}