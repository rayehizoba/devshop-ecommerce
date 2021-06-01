<?php

namespace Database\Seeders;

use App\Models\LicenseProduct;
use App\Models\Order;
use App\Models\OrderLine;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::factory(5)->create();
        foreach (Order::all() as $order) {
            for ($i = 0; $i < 3; $i++) {
                $license_product = LicenseProduct::inRandomOrder()->first();
                OrderLine::factory()->create([
                    'order_id' => $order->id,
                    'product_id' => $license_product->product_id,
                    'license_id' => $license_product->license_id,
                    'price' => $license_product->price,
                ]);
            }
        }
    }
}
