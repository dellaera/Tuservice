<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionPlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $planes = [
            [
                'nombre' => 'Trial 7 días',
                'slug' => 'trial',
                'descripcion' => 'Prueba gratuita sin tarjeta de crédito.',
                'precio_mensual' => 0,
                'max_profesionales' => 1,
                'max_turnos_mensuales' => 50,
                'incluye_recordatorios' => false,
                'incluye_estadisticas' => false,
                'incluye_reportes' => false,
            ],
            [
                'nombre' => 'Plan Básico',
                'slug' => 'basico',
                'descripcion' => '1 profesional, agenda, clientes y servicios ilimitados.',
                'precio_mensual' => 9,
                'max_profesionales' => 1,
                'max_turnos_mensuales' => 200,
                'incluye_recordatorios' => false,
                'incluye_estadisticas' => false,
                'incluye_reportes' => false,
            ],
            [
                'nombre' => 'Plan Pro',
                'slug' => 'pro',
                'descripcion' => 'Profesionales y turnos ilimitados, estadísticas y recordatorios.',
                'precio_mensual' => 14,
                'max_profesionales' => null,
                'max_turnos_mensuales' => null,
                'incluye_recordatorios' => true,
                'incluye_estadisticas' => true,
                'incluye_reportes' => true,
            ],
        ];

        DB::table('subscription_plans')->upsert(
            array_map(function ($plan) {
                return array_merge($plan, [
                    'moneda' => 'USD',
                    'activo' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }, $planes),
            uniqueBy: ['slug'],
            update: [
                'nombre',
                'descripcion',
                'precio_mensual',
                'max_profesionales',
                'max_turnos_mensuales',
                'incluye_recordatorios',
                'incluye_estadisticas',
                'incluye_reportes',
                'moneda',
                'activo',
                'updated_at',
            ]
        );
    }
}
