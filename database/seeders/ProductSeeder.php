<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\License;
use App\Models\LicenseProduct;
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
            $categories = Category::inRandomOrder()->take(rand(1,2))->pluck('id');
            $product->categories()->attach($categories);

            foreach(License::inRandomOrder()->take(rand(1,3))->pluck('id') as $license_id) {
                LicenseProduct::factory()->create([
                    'license_id' => $license_id,
                    'product_id' => $product->id,
                ]);
            }
        }
    }
}
