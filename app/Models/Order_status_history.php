<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order_status_history extends Model
{
    protected $fillable = [
        'id',
        'status',
        'changed_by'
    ];
    public function orders(): BelongsTo{
        return $this->belongsTo(Order::class);
    }
}
