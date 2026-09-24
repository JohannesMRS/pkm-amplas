<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderDetail extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'product_id',
        'quantity',
        'price',
        'subtotal',
        'order_id'  
    ];
    public function products():BelongsTo{
        return $this->belongsTo(Product::class);
    }

    public function orders(): BelongsTo{
        return $this->belongsTo(Order::class);
    }
}
