<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Orders extends Model
{
    public function customer(): hasOne
    {
        return $this->hasOne(Customers::class, 'id');
    }
}
