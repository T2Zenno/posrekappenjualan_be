<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Channel;
use App\Models\Payment;
use App\Models\Admin;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sale::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'product_id' => Product::factory(),
            'channel_id' => Channel::factory(),
            'payment_id' => Payment::factory(),
            'admin_id' => Admin::factory(),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'link' => $this->faker->optional()->url(),
            'date' => $this->faker->date(),
            'ship_date' => $this->faker->optional()->date(),
            'note' => $this->faker->optional()->sentence(),
        ];
    }
}
