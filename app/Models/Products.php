<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Products extends Model
{
    public function productTypes(): hasOne
    {
        return $this->hasOne(ProductTypes::class, 'id', 'type_id');
    }

    public function orderLines(): hasMany
    {
        return $this->hasMany(OrderLines::class, 'product_id');
    }
}
