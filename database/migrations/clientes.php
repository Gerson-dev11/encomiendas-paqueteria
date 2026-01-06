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
        Schema::create('clientes', function (Blueprint $table) {
            //Creación del uiid como llave primaria generado de manera aleatoria desde la base de datos
            //!NOTA: Asegurarse de que la extensión pgcrypto esté habilitada en PostgreSQL para usar gen_random_uuid()
            //Puedes habilitarla ejecutando: CREATE EXTENSION IF NOT EXISTS "pgcrypto";
            //ESTE TAMBIEN SE PUEDE GENERAR CON LARAVEL DESDE UN MODELO
            $table->uuid('cliente_id')
                ->primary()
                ->default(DB::raw('gen_random_uuid()'));

            $table->string('nombre', 200);
            $table->string('telefono', 30);

            //* CITEXT (PostgreSQL) para hacer el campo case insensitive
            /**
             * ❗ CITEXT no existe por defecto en  Laravel.
                Laravel NO soporta CITEXT nativo.

                Debes hacerlo así:

                DB::statement('CREATE EXTENSION IF NOT EXISTS citext');
                DB::statement('ALTER TABLE clientes ALTER COLUMN correo TYPE CITEXT');
             */
            $table->string('email', 100)->unique();
            
            //Relaciones a tabla de paises
            $table->char('pais_id', 10);
            $table->foreign('pais_codigo')
            ->references('codigo_iso')
            ->on('paises');

            // Auditoría
            $table->timestampTz('creado_el')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('creado_por')->nullable();
            $table->timestampTz('actualizado_el')->nullable();
            $table->integer('actualizado_por')->nullable();

            $table->foreign('creado_por')->references('empleado_id')->on('empleados');
            $table->foreign('actualizado_por')->references('empleado_id')->on('empleados');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
