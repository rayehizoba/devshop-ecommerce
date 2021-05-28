<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicenseProduct extends Model
{
    use HasFactory;

    protected $table = 'license_product';

    public function license()
    {
        return $this->belongsTo(License::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
