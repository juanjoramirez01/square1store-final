<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            Order::factory()->create([
                'user_id' => 1,
                'name' => fake()->name(),
                'address' => fake()->address(),
                'price' => fake()->randomFloat(2, 10, 100),
            ]);
        }
    }
}
