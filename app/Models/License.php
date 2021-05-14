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

    static function validationRules()
    {
        return [
            'id' => 'nullable',
            'name' => 'required',
            'order' => 'required',
            'summary' => 'required',
            'description' => 'required',
        ];
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function getUpdatedAtForHumansAttribute()
    {
        return $this->updated_at->format('M, d Y');
    }
}
