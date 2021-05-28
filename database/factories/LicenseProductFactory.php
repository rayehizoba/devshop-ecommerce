<?php

namespace Database\Factories;

use App\Models\LicenseProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class LicenseProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LicenseProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'download_path' => 'https://www.instamobile.io/?download_file=884&order=wc_order_60ac5e967570e&uid=cc1ea4f213737cf981700cf515f79315f869fcd26ae12001f26f2a14edfa185a&key=84bb213a-5d06-4371-9bea-eba90f7821c1',
            'price' => rand(0,100)
        ];
    }
}
