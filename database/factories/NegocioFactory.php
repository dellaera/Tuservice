<?php

namespace Database\Factories;

use App\Models\Rubro;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Negocio>
 */
class NegocioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nombre = fake()->unique()->company();

        return [
            'usuario_id' => User::factory(),
            'rubro_id' => Rubro::factory(),
            'nombre' => $nombre,
            'descripcion' => fake()->sentence(),
            'direccion' => fake()->streetAddress(),
            'ciudad' => fake()->city(),
            'telefono' => fake()->phoneNumber(),
            'email' => fake()->companyEmail(),
            'slug' => str()->slug($nombre . '-' . fake()->unique()->numberBetween(1, 9999)),
            'sitio_web' => fake()->optional()->url(),
            'timezone' => 'America/Argentina/Buenos_Aires',
            'trial_ends_at' => now()->addDays(7),
        ];
    }
}
