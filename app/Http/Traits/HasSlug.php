<?php

namespace App\Http\Traits;

trait HasSlug
{
    protected function incrementSlug($slug)
    {

        $original = $slug;
        $count = 2;

        while (static::whereSlug($slug)->exists()) {
            $slug = "{$original}-" . $count++;
        }

        return $slug;
    }
}
