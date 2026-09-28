<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    protected $fillable = [
        'id', 'user_id', 'label', 'full_address', 'longitude', 'latitude', 'is_primary'
    ];
    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
}
