<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Payment;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $paymentMethods = [
            ['name' => 'Cash', 'desc' => 'Cash payment', 'code' => 'CASH'],
            ['name' => 'Credit Card', 'desc' => 'Credit card payment', 'code' => 'CC'],
            ['name' => 'Bank Transfer', 'desc' => 'Bank transfer payment', 'code' => 'BT'],
            ['name' => 'PayPal', 'desc' => 'PayPal payment', 'code' => 'PP'],
            ['name' => 'Digital Wallet', 'desc' => 'Digital wallet payment', 'code' => 'DW'],
        ];

        $method = $this->faker->randomElement($paymentMethods);

        return [
            'name' => $method['name'],
            'desc' => $method['desc'],
            'code' => $method['code'],
        ];
    }
}
