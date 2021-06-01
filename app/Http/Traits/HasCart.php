<?php

namespace App\Http\Traits;

use App\Models\License;

trait HasCart
{
    private function _getCartContent()
    {
        $items = [];
        $cartContent = \Cart::getContent();
        foreach ($cartContent as $each) {
            array_push($items, [
                'id' => $each->id,
                'name' => $each->name,
                'quantity' => $each->quantity,
                'price' => $each->price,
                'slug' => $each->associatedModel->slug,
                'cover_image_path' => $each->associatedModel->cover_image_path,
                'license_name' => License::find($each->attributes->license_id)->name,
            ]);
        }
        return $items;
    }
}
