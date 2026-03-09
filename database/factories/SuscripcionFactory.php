<?php

namespace Database\Factories;

use App\Models\Negocio;
use App\Models\SubscriptionPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Suscripcion>
 */
class SuscripcionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fechaInicio = fake()->dateTimeBetween('-1 month', 'now');

        return [
            'negocio_id' => Negocio::factory(),
            'subscription_plan_id' => SubscriptionPlan::factory(),
            'plan' => fake()->randomElement(['trial', 'basico', 'pro']),
            'fecha_inicio' => $fechaInicio->format('Y-m-d'),
            'fecha_fin' => fake()->optional()->dateTimeBetween('now', '+1 month')?->format('Y-m-d'),
            'estado' => fake()->randomElement(['activa', 'pausada', 'cancelada', 'expirada']),
        ];
    }
}
