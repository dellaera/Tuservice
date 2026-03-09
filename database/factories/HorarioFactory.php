<?php

namespace Database\Factories;

use App\Models\Profesional;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Horario>
 */
class HorarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $horaInicio = fake()->dateTimeBetween('08:00', '12:00');
        $duracion = fake()->randomElement([30, 60, 90]);

        return [
            'profesional_id' => Profesional::factory(),
            'dia_semana' => fake()->numberBetween(0, 6),
            'hora_inicio' => $horaInicio->format('H:i:s'),
            'hora_fin' => $horaInicio->modify("+{$duracion} minutes")->format('H:i:s'),
        ];
    }
}
