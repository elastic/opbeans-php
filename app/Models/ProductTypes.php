<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductTypes extends Model
{
    public function products(): hasMany
    {
        return $this->hasMany(Products::class, 'type_id');
    }
}
