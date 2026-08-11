<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        $stock = fake()->randomElement([
            fake()->numberBetween(0, 2),   // Critical
            fake()->numberBetween(3, 10),  // Low Stock
            fake()->numberBetween(11, 100), // In Stock
        ]);

        return [
            'name' => fake()->words(3, true),

            'description' => fake()->paragraph(),

            'price' => fake()->randomFloat(2, 10, 1000),

            'stock' => $stock,

            'category' => fake()->randomElement([
                'Electronics',
                'Clothing',
                'Books',
                'Home & Garden',
            ]),

            'is_active' => fake()->boolean(80),
        ];
    }
}