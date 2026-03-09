<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class RubrosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rubros = [
            'barberia',
            'peluqueria',
            'estetica',
            'tatuajes',
            'masajes',
            'nutricion',
            'psicologia',
            'consultorios',
        ];

        DB::table('rubros')->insert(collect($rubros)->map(function ($nombre) {
            return [
                'nombre' => Str::title(str_replace('_', ' ', $nombre)),
                'slug' => Str::slug($nombre),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->all());
    }
}
