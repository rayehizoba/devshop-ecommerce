<?php

namespace App\Models;

use App\Http\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'name',
        'order',
    ];

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

    public function latestProducts()
    {
        return $this->products()->orderByDesc('updated_at');
    }

    public function cheapestProducts()
    {
        return DB
            ::table('category_product as cp')
            ->select('cp.category_id', 'p.*')
            ->join(DB::raw('(
                    SELECT p.*, MIN(lp.price) AS starting_price
                    FROM products AS p
                             JOIN license_product lp on p.id = lp.product_id
                    GROUP BY p.id
                ) p'),
                'cp.product_id', '=', 'p.id')
            ->orderBy('p.starting_price');


        return DB::select('
            SELECT cp.category_id, p.*
            FROM category_product cp
            INNER JOIN (
                SELECT p.*, MIN(lp.price) AS starting_price
                FROM products AS p
                         JOIN license_product lp on p.id = lp.product_id
                GROUP BY p.id
            ) p ON cp.product_id = p.id
            WHERE cp.category_id = 2;
        ');

//        return $this->products()->orderBy('starting_price');
    }

    public function getPremiumProductsAttribute()
    {
        return $this->products()->cursor()->sortByDesc('starting_price');
    }

}
