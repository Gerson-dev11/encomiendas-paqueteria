<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('otp_codes', function (Blueprint $table) {
            $table->id();

            // Usuario al que pertenece el OTP
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // Hash del código OTP (NUNCA el código en claro)
            $table->string('code_hash', 255);

            // Fecha de expiración
            $table->timestamp('expires_at');

            // Cantidad de intentos
            $table->unsignedSmallInteger('attempts')->default(0);

            // Marca de uso del OTP
            $table->timestamp('used_at')->nullable();

            // Auditoría mínima
            $table->timestamp('created_at')->useCurrent();

            /**
             * Restricción:
             * Un solo OTP ACTIVO por usuario.
             * Activo = no usado y no expirado
             *
             * PostgreSQL soporta índices parciales, Laravel también.
             */
            $table->unique('user_id', 'uq_otp_user_active')
                  ->whereNull('used_at')
                  ->where('expires_at', '>', DB::raw('NOW()'));
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('otp_codes');
    }
};
