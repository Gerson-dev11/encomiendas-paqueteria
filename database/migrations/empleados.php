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
            //* Campos de la tabla empleados */
            $table->id('empleado_id'); // Requerido (Primary Key)
            $table->string('nombre_completo', 200); // Requerido
            $table->string('correo')->unique(); // Requerido y único
            $table->string('password', 255); // Requerido
            $table->string('direccion', 300)->nullable(); // Opcional
            $table->string('telefono', 100);
            $table->boolean('activo')->default(true); // Requerido (tiene valor por defecto)
            $table->string('dui', 10)->unique(); // Requerido y único
            $table->date('fecha_contratacion')->useCurrent(); // Requerido (usa fecha actual)
            $table->foreignId('creado_por')
                ->nullable()
                ->constrained('empleados', 'empleado_id')
                ->nullOnDelete();

            // rol_id es obligatorio para saber qué permisos tiene el empleado
            $table->foreignId('rol_id')->constrained('roles', 'rol_id');

            // creado_por: Aquí hay una excepción lógica.
            // El primer empleado del sistema no puede ser creado por nadie más,
            // por lo que este campo suele ser el único que permite null.
            $table->timestampTz('creado_el')->useCurrent(); // Requerido
            // actualizado_el es null por defecto hasta que se haga el primer cambio
            $table->timestampTz('actualizado_el')->nullable();


            //* Seguridad y Bloqueo manual de cuentas */
            $table->integer('intentos_fallidos')->default(0); // Para contar los errores
            $table->timestamp('tiempo_bloqueado')->nullable(); // Para bloqueos temporales (ej. 15 min)
            $table->boolean('cuenta_bloqueada')->default(false); // Bloqueo administrativo manual
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
