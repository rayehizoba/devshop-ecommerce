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

    static function validationRules()
    {
        return [
            'id'               => 'nullable',
            'cover_image_path' => 'required',
            'name'             => 'required',
            'web_url'          => 'nullable',
            'play_store_url'   => 'nullable',
            'app_store_url'    => 'nullable',
            'description'      => 'required',
        ];
    }

    public function setNameAttribute($value) {

        if (static::whereSlug($slug = Str::slug($value))->exists()) {
            $slug = $this->incrementSlug($slug);
        }

        $this->attributes['name'] = $value;
        $this->attributes['slug'] = $slug;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function licenses()
    {
        return $this->belongsToMany(License::class)->withPivot('price')->orderBy('price');
    }

    public function getUpdatedAtForHumansAttribute()
    {
        return $this->updated_at->format('M, d Y');
    }

    public function getStartingPriceAttribute()
    {
        $first_license = $this->licenses()->first();
        return $first_license ? $first_license->pivot->price : 0;
    }
}
