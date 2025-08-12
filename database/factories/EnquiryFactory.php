<?php

namespace Database\Factories;

use App\Models\Enquiry;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enquiry>
 */
class EnquiryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Enquiry::class;

    public function definition(): array
    {
        $startDate = now()->addDays(rand(30, 365));
        $endDate = $startDate->copy()->addDays(rand(5, 14));

        return [
            //
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'travel_start_date' => $startDate,
            'travel_end_date' => $endDate,
            'number_of_people' => rand(1, 10),
            'preferred_destinations' => json_encode(
                $this->faker->randomElements(
                    ['Sigiriya', 'Ella', 'Kandy', 'Galle', 'Nuwara Eliya', 'Yala', 'Mirissa'],
                    rand(1, 3)
                )
            ),
            'budget' => $this->faker->randomFloat(2, 500, 5000),
            'status' => $this->faker->randomElement(['pending', 'in-progress']),
            'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'assigned_agent_id' => User::factory()->agent()
        ];
    }

    public function pending(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'pending',
        ]);
    }
}
