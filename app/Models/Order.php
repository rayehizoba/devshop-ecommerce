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
    ];

    public function lines()
    {
        return $this->hasMany(OrderLine::class);
    }
}
