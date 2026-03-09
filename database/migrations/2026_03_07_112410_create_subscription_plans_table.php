<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('slug')->unique();
            $table->string('descripcion')->nullable();
            $table->decimal('precio_mensual', 8, 2)->default(0);
            $table->string('moneda', 3)->default('USD');
            $table->unsignedInteger('max_profesionales')->nullable();
            $table->unsignedInteger('max_turnos_mensuales')->nullable();
            $table->boolean('incluye_recordatorios')->default(false);
            $table->boolean('incluye_estadisticas')->default(false);
            $table->boolean('incluye_reportes')->default(false);
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
