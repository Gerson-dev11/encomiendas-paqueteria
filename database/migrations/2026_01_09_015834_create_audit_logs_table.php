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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();

            //RElación con el ususario que realiza la acción
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            //Descripcion de las acciones realizadas
            $table->string('action', 255);
            $table->string('table_name', 100);
            $table->unsignedBigInteger('record_id');

            //Datos antes y despues de la acción
            $table->jsonb('old_values')->nullable();
            $table->jsonb('new_values')->nullable();

            //Marca de direcion IP y User Agent (Osea doxeado jajaja)
            $table->string('ip_addres', 45)->nullable();
            $table->string('user_agent')->nullable();

            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
