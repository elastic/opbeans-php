<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Products extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'sku',
        'name',
        'description',
        'stock',
        'cost',
        'selling_price',
        'type_id',
    ];

    public function productTypes(): HasOne
    {
        return $this->hasOne(ProductTypes::class, 'id', 'type_id');
    }

    public function orderLines(): HasMany
    {
        return $this->hasMany(OrderLines::class, 'product_id');
    }
}
