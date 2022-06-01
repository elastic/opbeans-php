<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Orders extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'created_at',
        'customer_id',
    ];

    public function customer(): HasOne
    {
        return $this->hasOne(Customers::class, 'id');
    }

    public function setCreatedAt($createdAt): void
    {
        $this->created_at = $createdAt;
    }
}
