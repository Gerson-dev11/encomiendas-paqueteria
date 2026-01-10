<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Detalles importantes
     * slug UNIQUE → Policies/Gates
     * group_name → UI, filtros, admin panel
     * NO index extra aún (slug ya es unique)
     */
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id(); // BIGINT auto incremental manejado por laravel estandar
            $table->string('name', 100);
            $table->string('slug', 150)->unique(); //Nombre logico para la maquina
            $table->string('group_name', 50); //Filtros para UI y manejo demostrativo
            
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
