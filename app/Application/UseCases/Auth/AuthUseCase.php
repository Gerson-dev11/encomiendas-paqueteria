<?php

namespace App\Application\UseCases\Auth;

use App\Application\DTOs\Auth\AuthDTO;
use App\Domain\Exceptions\Auth\AuthDomainException;

use App\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthUseCase
{
    public function __construct(private UserRepositoryInterface $userRepository) {}

    /**
     * @return string El token OTP temporal para la cookie
     *
     * @throws AuthDomainException
     */
    public function execute(AuthDTO $authDTO): string
    {
        //* funcion bool para verificar si el usuario existe
        $user = $this->userRepository->findByEmail($authDTO->email); 

        if (! $user) {
            throw new AuthDomainException('INVALID_CREDENTIALS', 401);
        }

        // 3. Si el usuario EXISTE, pero la contraseña es incorrecta
        if (! Hash::check($authDTO->password, $user->password_hash)) {
            // Aquí SI es seguro llamar a la función porque $user es un objeto válido
            $this->manejarFalloAutenticacion($user);
            throw new AuthDomainException('INVALID_CREDENTIALS', 401);
        }

        // 3. Validación de Bloqueo Administrativo
        if ($user->cuenta_bloqueada) {
            throw new AuthDomainException('ACCOUNT_BLOCKED_ADMIN', 403);
        }

        // 4. Validación de Bloqueo Temporal por intentos
        if ($user->tiempo_bloqueado && $user->tiempo_bloqueado > now()) {
            $minutosRestantes = $user->tiempo_bloqueado->diffInMinutes(now());

            throw new AuthDomainException(
                'ACCOUNT_LOCKED_TEMP',
                403,
                ['minutes' => $minutosRestantes] // Metadatos para el frontend
            );
        }

        // --- FLUJO DE ÉXITO ---

        // 5. Resetear intentos
        $this->userRepository->resetearIntentosFallidos($authDTO->email);

        // 6. Generar Seguridad para el OTP
        $otpCode = (string) random_int(100000, 999999);
        $otpToken = Str::random(64);

        // 7. Persistir OTP en tabla independiente (Manejado por el repositorio)
        $this->userRepository->saveOtpData([
            'email' => $user->email,
            'otp_code' => $otpCode,
            'otp_token' => $otpToken,
            'expires_at' => now()->addMinutes(15),
        ]);

        // 8. Disparar evento de envío de correo (Inyectar el código)
        // Event::dispatch(new OtpGeneratedEvent($user->email, $otpCode));

        return $otpToken;
    }

    private function manejarFalloAutenticacion($user): void
    {
        $nuevosIntentos = $user->intentos_fallidos + 1;
        $minutosBloqueo = 0;

        // Lógica exponencial: cada 5 intentos bloqueamos
        if ($nuevosIntentos % 5 === 0) {
            $potencia = $nuevosIntentos / 5;
            $minutosBloqueo = 5 * (2 ** ($potencia - 1)); // 5, 10, 20...
        }

        $this->userRepository->incrementearIntentosFallidos($user->email, $nuevosIntentos, $minutosBloqueo);
    }
}
