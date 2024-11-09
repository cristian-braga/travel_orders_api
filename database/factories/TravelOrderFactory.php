<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TravelOrder>
 */
class TravelOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = ['solicitado', 'aprovado', 'cancelado'];

        return [
            'solicitante' => fake()->name(),
            'destino' => fake()->city(),
            'data_ida' => fake()->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
            'data_volta' => fake()->dateTimeBetween('+1 year', '+2 years')->format('Y-m-d'),
            'status' => fake()->randomElement($status)
        ];
    }
}
