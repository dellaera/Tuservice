<?php

namespace Database\Factories;

use App\Models\Negocio;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profesional>
 */
class ProfesionalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'negocio_id' => Negocio::factory(),
            'usuario_id' => User::factory(['rol' => 'profesional']),
            'nombre' => fake()->name(),
            'activo' => true,
        ];
    }
}
