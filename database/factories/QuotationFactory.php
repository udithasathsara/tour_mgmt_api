<?php

namespace Database\Factories;

use App\Models\Itinerary;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quotation>
 */
class QuotationFactory extends Factory
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
            'id' => Str::uuid(),
            'itinerary_id' => Itinerary::factory(),
            'title' => $this->faker->sentence(3),
            'price_per_person' => $this->faker->randomFloat(2, 100, 5000),
            'currency' => $this->faker->randomElement(['USD', 'EUR', 'GBP']),
            'notes' => $this->faker->paragraph,
            'is_final' => $this->faker->boolean(80)
        ];
    }
}
