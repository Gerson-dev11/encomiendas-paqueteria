<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\UserRepositoryInterface;
// Importamos el modelo que vive en Infraestructura
use App\Infrastructure\DataBase\Entities\User; 
use Illuminate\Support\Facades\DB;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function findByEmail(string $email)
    {
        // Usamos la clase User que importamos arriba
        return User::where('email', $email)->first();
    }

    public function resetearIntentosFallidos(string $email): void
    {
        User::where('email', $email)->update([
            'intentos_fallidos' => 0,
            'tiempo_bloqueado' => null
        ]);
    }

    public function incrementearIntentosFallidos(string $email, int $intentos, int $minutos): void
    {
        $data = ['intentos_fallidos' => $intentos];

        if ($minutos > 0) {
            $data['tiempo_bloqueado'] = now()->addMinutes($minutos);
        }

        User::where('email', $email)->update($data);
    }

    public function saveOtpData(array $data): void
    {
        // Para el OTP usamos DB directamente (Query Builder) para no necesitar 
        // crear otro modelo Eloquent extra si no quieres.
        DB::table('password_otps')->updateOrInsert(
            ['email' => $data['email']], 
            [
                'otp_code' => $data['otp_code'],
                'otp_token' => $data['otp_token'],
                'expires_at' => $data['expires_at'],
                'created_at' => now()
            ]
        );
    }
}