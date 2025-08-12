<?php

namespace Database\Factories;

use App\Models\Enquiry;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Itinerary>
 */
class ItineraryFactory extends Factory
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
            'enquiry_id' => Enquiry::factory(),
            'agent_id' => User::factory()->agent(),
            'title' => $this->faker->sentence(),
            'notes' => $this->faker->paragraph(),
            'days' => [
                [
                    'day' => 1,
                    'location' => $this->faker->city(),
                    'activities' => ['Arrival', 'Check-in']
                ],
                [
                    'day' => 2,
                    'location' => $this->faker->city(),
                    'activities' => ['City tour']
                ]
            ]
        ];
    }
}
