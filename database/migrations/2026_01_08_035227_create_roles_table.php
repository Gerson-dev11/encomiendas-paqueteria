<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * $table->id() → BIGINT, compatible con users
     * $table->timestamps() → Laravel maneja fechas, no SQL puro
     * Nada de enums → seeders mandan
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id(); //BIGINT auto incremental (manejo de laravel estandar)
            $table->string('name', 100)->unique();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
