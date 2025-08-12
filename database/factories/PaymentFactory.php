<?php

namespace Database\Factories;

use App\Models\Quotation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'quotation_id' => Quotation::factory(),
            'amount' => $this->faker->randomFloat(2, 50, 2000),
            'payment_method' => $this->faker->randomElement(['cash', 'credit_card', 'bank_transfer']),
            'transaction_reference' => 'PAY-' . Str::upper(Str::random(10))
        ];
    }
}
