<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use FakerCommerce\Faker\FakerFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $fakerStore = FakerFactory::create();

        try {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        } catch (\Exception $e) {
            // do nothing
        }

        $categoryNames = [
            "men's clothing",
            "women's clothing",
            "watches",
            "jewelry",
            "electronics",
            'discounts'
        ];

        foreach ($categoryNames as $categoryName) {
            try {
                $categories[] = \App\Models\Category::factory()->create([
                    'name' => $categoryName,
                    'slug' => Str::slug($categoryName),
                    'description' => fake()->paragraph,
                ]);
            } catch (\Exception $e) {
                // do nothing
            }
        }

        $categories = Category::all()->pluck('id')->toArray();

        foreach (range(1, 10) as $index) {
            $name = $fakerStore->name();
            try {
                $product = Product::factory()->create([
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'brand' => fake()->domainWord(),
                    'description' => fake()->paragraph(),
                    'price' => fake()->randomFloat(2, 10, 1000),
                    'sale_price' => fake()->boolean() ? fake()->randomFloat(2, 10, 1000) : null,
                    'stock' => fake()->numberBetween(1, 100),
                    'images' => $this->getRandomImages($name),
                    'rating' => fake()->numberBetween(1, 5),
                    'review_count' => fake()->numberBetween(1, 100),
                    'sizes' => ['S', 'M', 'L', 'XL'],
                    'colors' => $this->getRandomHexColors(fake()),
                ]);

                $product->categories()->attach(
                    fake()->randomElements($categories, rand(1, count($categories)))
                );
            } catch (\Exception $e) {
                dd($e->getMessage());
            }
        }
    }

    function getRandomHexColors($faker, $min = 1, $max = 10):array {
        $count = rand($min, $max);
        $colors = [];

        for ($i = 0; $i < $count; $i++) {
            $colors[] = $faker->hexColor();
        }

        return $colors;
    }

    function getRandomImages($name, $min = 1, $max = 10):array {
        $count = rand($min, $max);
        $images = [];

        for ($i = 0; $i < $count; $i++) {
            $images[] = 'https://imageplaceholder.net/700x900?text='.Str::slug($name);
        }

        return $images;
    }
}
