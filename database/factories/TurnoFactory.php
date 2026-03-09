<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Negocio;
use App\Models\Profesional;
use App\Models\Servicio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Turno>
 */
class TurnoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fecha = fake()->dateTimeBetween('now', '+2 weeks');
        $inicio = (clone $fecha)->setTime(fake()->numberBetween(9, 18), fake()->randomElement([0, 30]));
        $fin = (clone $inicio)->modify('+1 hour');

        return [
            'negocio_id' => Negocio::factory(),
            'profesional_id' => Profesional::factory(),
            'cliente_id' => Cliente::factory(),
            'servicio_id' => Servicio::factory(),
            'fecha' => $inicio->format('Y-m-d'),
            'hora_inicio' => $inicio->format('H:i:s'),
            'hora_fin' => $fin->format('H:i:s'),
            'estado' => fake()->randomElement(['pendiente', 'confirmado', 'cancelado', 'completado']),
            'precio' => fake()->randomFloat(2, 10, 150),
            'notas' => fake()->optional()->sentence(),
            'recordatorio_enviado_at' => null,
        ];
    }
}
