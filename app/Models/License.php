<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'order',
        'summary',
        'description',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
