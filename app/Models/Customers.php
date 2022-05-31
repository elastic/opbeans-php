<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customers extends Model
{
    public function orders(): HasMany
    {
        return $this->hasMany(Orders::class, 'customer_id', 'id');
    }
}
