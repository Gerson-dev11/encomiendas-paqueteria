<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id('empleado_id'); // Requerido (Primary Key)
            $table->string('nombre_completo', 200); // Requerido
            $table->string('correo')->unique(); // Requerido y único
            $table->string('password', 255); // Requerido
            $table->string('direccion', 300)->nullable(); // Opcional

            // Si el teléfono DEBE ser obligatorio, quitamos ->nullable()
            $table->string('telefono', 100);

            $table->boolean('activo')->default(true); // Requerido (tiene valor por defecto)
            $table->string('dui', 10)->unique(); // Requerido y único

            $table->date('fecha_contratacion')->useCurrent(); // Requerido (usa fecha actual)

            $table->foreignId('creado_por')
                ->nullable()
                ->constrained('empleados', 'empleado_id')
                ->nullOnDelete();
            // Seguridad

            // Relaciones
            // rol_id es obligatorio para saber qué permisos tiene el empleado
            $table->foreignId('rol_id')->constrained('roles', 'rol_id');

            // creado_por: Aquí hay una excepción lógica.
            // El primer empleado del sistema no puede ser creado por nadie más,
            // por lo que este campo suele ser el único que permite null.

            $table->timestampTz('creado_el')->useCurrent(); // Requerido
            // actualizado_el es null por defecto hasta que se haga el primer cambio
            $table->timestampTz('actualizado_el')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
