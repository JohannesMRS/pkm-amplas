<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'id', 'order_id', 'amount', 'method', 'proof', 'paid_at'
    ];
    public function orders(): BelongsTo{
        return $this->belongsTo(Order::class, 'order_id');
    }
}
