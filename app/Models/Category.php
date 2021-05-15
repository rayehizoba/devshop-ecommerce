<?php

namespace App\Models;

use App\Http\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'name',
        'order',
    ];

    static function validationRules()
    {
        return [
            'id' => 'nullable',
            'name' => 'required',
            'order' => 'required'
        ];
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function setNameAttribute($value) {

        if (static::whereSlug($slug = Str::slug($value))->exists()) {
            $slug = $this->incrementSlug($slug);
        }

        $this->attributes['name'] = $value;
        $this->attributes['slug'] = $slug;
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    public function parent()
    {
        return $this->belongsTo(Client::class, 'parent_id');
    }

    public function parentRecursive()
    {
        return $this->parent()->with('parentRecursive');
    }

    public function getLatestProductsAttribute()
    {
        return $this->products()->orderByDesc('updated_at')->get();
    }

    public function getCheapestProductsAttribute()
    {
        return $this->products()->cursor()->sortBy('starting_price');
    }

    public function getPremiumProductsAttribute()
    {
        return $this->products()->cursor()->sortByDesc('starting_price');
    }

}
