<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'type' => fake()->randomElement(['electronics', 'clothing', 'food', 'books', 'home', 'sports']),
            'sku' => fake()->unique()->regexify('[A-Z]{3}[0-9]{6}'),
        ];
    }
}
