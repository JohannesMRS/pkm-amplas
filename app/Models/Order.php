<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'id', 'order_numbers', 'user_id', 'status', 'total_price', 'paymentstatus', 'pickup_date', 'delivery_date', 'note'
    ];

    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function orderDetails():HasMany{
        return $this->hasMany(OrderDetail::class);
    }

    public function payments():HasMany{
        return $this->hasMany(Payment::class);
    }

    public function order_status_histories():HasMany{
        return $this->hasMany(Order_status_history::class);
    }
    
}
