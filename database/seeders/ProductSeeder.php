<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory(20)->create();

        foreach (Product::all() as $product) {
            $categories = \App\Models\Category::inRandomOrder()->take(rand(1,2))->pluck('id');
            $product->categories()->attach($categories);

            $licenses = \App\Models\License::inRandomOrder()->take(rand(1,3))->pluck('id');
            $product->licenses()->attach($licenses, ['price' => rand(0,100)]);
        }
    }
}
