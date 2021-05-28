<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $chance = (int) 100 / 3;
        $files = Storage::allFiles('public/demo_products');
        $randomFile = $files[rand(0, count($files) - 1)];
        return [
            'cover_image_path' => $randomFile,
            'name' => $this->faker->sentence(),
            'slug' => $this->faker->slug(),
            'web_url' => (rand(1,100)<=$chance) ? $this->faker->url() : null,
            'play_store_url' => (rand(1,100)<=$chance) ? $this->faker->url() : null,
            'app_store_url' => (rand(1,100)<=$chance) ? $this->faker->url() : null,
            'description' => $this->faker->paragraphs(3,5),
        ];
    }
}
