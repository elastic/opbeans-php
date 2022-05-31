<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderLines extends Model
{
    public function products(): HasOne
    {
        return $this->hasOne(Products::class, 'id', 'product_id');
    }

    public function order(): HasOne
    {
        return $this->hasOne(Orders::class, 'id');
    }
}
