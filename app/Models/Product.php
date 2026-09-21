<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'id',
        'name', // jenis layanan (cuci kering, )
        'description',
        'price',
        'unit',
        'is_active'

    ];
    
    public function orderDetails():HasMany{
        return $this->hasMany(OrderDetail::class);
    }
}
