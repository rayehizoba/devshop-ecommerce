<?php

namespace App\Models;

use App\Http\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'cover_image_path',
        'name',
        'slug',
        'web_url',
        'play_store_url',
        'app_store_url',
        'description',
    ];

    protected $appends = [
        'starting_price',
        'category_ids',
        'license_prices',
        'purchases',
    ];

    public function setNameAttribute($value) {

        if (static::whereSlug($slug = Str::slug($value))->exists()) {
            $slug = $this->incrementSlug($slug);
        }

        $this->attributes['name'] = $value;
        $this->attributes['slug'] = $slug;
    }

    public function screenshots()
    {
        return $this->hasMany(ProductScreenshot::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function licenses()
    {
        return $this->belongsToMany(License::class)->orderBy('order')->withPivot('price', 'download_path');
    }

    public function cheapestLicense()
    {
        return $this->licenses()->orderBy('price')->first();
    }

    public function getStartingPriceAttribute()
    {
        return $this->cheapestLicense()->pivot->price ?? 0;
    }

    public function getCategoryIdsAttribute()
    {
        return $this->categories()->pluck('id');
    }

    public function getLicensePricesAttribute()
    {
        $pivots = $this->licenses()->get()->pluck('pivot')->toArray();
        $prices = [];

        foreach ($pivots as $pivot) {
            $prices[$pivot['license_id']] = ['price' => $pivot['price']];
        }

        return $prices;
    }

    public function getPurchasesAttribute()
    {
        return $this->hasMany(OrderLine::class)->count();
    }
}
