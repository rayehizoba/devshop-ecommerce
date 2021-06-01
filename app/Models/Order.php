<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'payment_intent_id',
        'payment_intent_status',
        'number',
    ];

    protected $appends = [
        'total'
    ];

    public function lines()
    {
        return $this->hasMany(OrderLine::class);
    }

    public function getTotalAttribute()
    {
        return $this->lines()->sum('price');
    }
}
