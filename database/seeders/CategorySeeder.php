<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'E-Commerce',
            'Personalization',
            'Dating',
            'Travel',
            'Social Networking',
            'Health-Fitness',
            'Food-Drink',
            'Productivity',
            'Portfolio & Blog',
            'Finance',
            'Trivia',
        ];

        foreach ($categories as $order => $category) {
            Category::create([
                'name' => $category,
                'slug' => Str::slug($category),
                'order' => $order +1,
            ]);
        }
    }
}
