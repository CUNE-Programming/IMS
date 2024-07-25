<?php

namespace Database\Factories;

use App\Models\Variant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Season>
 */
class SeasonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $registration_start = fake()->dateTimeBetween('-1 month', '+1 month');
        $registration_end = fake()->dateTimeBetween($registration_start, '+1 month');
        $start_date = fake()->dateTimeBetween($registration_end, '+1 month');
        $end_date = fake()->dateTimeBetween($start_date, '+3 months');

        return [
            'variant_id' => Variant::factory(),
            'start_date' => $start_date->format('Y-m-d'),
            'end_date' => $end_date->format('Y-m-d'),
            'description' => fake()->paragraphs(asText: true),
            'registration_start' => $registration_start->format('Y-m-d'),
            'registration_end' => $registration_end->format('Y-m-d'),
        ];
    }
}
