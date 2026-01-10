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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            //Parametros de identidad
            $table->string('full_name', 150);
            $table->string('email', 100)->unique();
            $table->string('phone', 100)->unique();

            //Parametros de auth que se manejan con Laravel (Sactum, Resdis, etc)
            $table->string('password');
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();

            //estado general de la actividad del usuario (no logico del login)
            $table->boolean('is_active')->default(true);

            //relaciones del negocio (gestion de roles)
            $table->foreignId('role_id')
                    ->constrained('roles')
                    ->restrictOnDelete();

            //auditoria
            $table->foreignId('created_by')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
