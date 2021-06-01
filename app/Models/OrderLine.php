<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'license_id',
        'quantity',
        'price',
    ];

    protected $appends = [
        'package_path'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function license()
    {
        return $this->belongsTo(License::class);
    }

    public function getPackagePathAttribute()
    {
        return LicenseProduct::firstWhere([
            'product_id' => $this->product->id,
            'license_id' => $this->license->id,
        ])->package_path;
    }
}
