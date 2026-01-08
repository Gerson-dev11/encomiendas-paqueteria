<?php

namespace App\Application\UseCases\Auth;

use App\Application\DTOs\Auth\AuthDTO;
use App\Domain\Exceptions\Auth\AuthDomainException;
use App\Domain\Repositories\AuthRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class AuthUseCase
{
    public function __construct(private AuthRepositoryInterface $userRepository) {}

    /**
     * @throws AuthDomainException
     */
    public function execute(AuthDTO $authDTO): string
    {
        try {                  
            // 1. Intento de búsqueda de usuario (Infraestructura)
            $user = $this->userRepository->findByEmail($authDTO->email);
        } catch (Throwable $e) {
            // Error de conexión a DB, tabla no existe, etc.
            Log::error("Error de infraestructura al buscar usuario: " . $e->getMessage());
            throw new AuthDomainException('SERVICE_UNAVAILABLE', 503);
        }

        // 2. Validación de existencia
        if (! $user) {
            throw new AuthDomainException('INVALID_CREDENTIALS', 401);
        }

        // 3. Verificación de contraseña
        if (!Hash::check($authDTO->password, $user->password)) {
            $this->manejarFalloAutenticacion($user);
            throw new AuthDomainException('INVALID_CREDENTIALS', 401);
        }

        // 4. Validaciones de estado del usuario
        if ($user->cuenta_bloqueada) {
            throw new AuthDomainException('ACCOUNT_BLOCKED_ADMIN', 403);
        }

        if ($user->tiempo_bloqueado && $user->tiempo_bloqueado > now()) {
            $minutosRestantes = $user->tiempo_bloqueado->diffInMinutes(now());
            throw new AuthDomainException(
                'ACCOUNT_LOCKED_TEMP', 
                403, 
                ['minutes' => $minutosRestantes]
            );
        }

        // --- FLUJO DE ÉXITO (ZONA CRÍTICA DE PERSISTENCIA) ---

        try {
            // 5. Resetear intentos y preparar OTP
            $this->userRepository->resetearIntentosFallidos($authDTO->email);

            $otpCode = (string) random_int(100000, 999999);
            $otpToken = Str::random(64);

            // 6. Persistir OTP en PostgreSQL
            $this->userRepository->saveOtpData([
                'email' => $user->email,
                'otp_code' => $otpCode,
                'otp_token' => $otpToken,
                'expires_at' => now()->addMinutes(15),
            ]);

            // 7. Envío de correo (Si falla aquí, capturamos el error)
            Event::dispatch(new OtpGeneratedEvent($user->email, $otpCode));

            return $otpToken;

        } catch (Throwable $e) {
            // Si falla el guardado del OTP o el reseteo de intentos
            Log::critical("Error crítico en flujo de éxito login: " . $e->getMessage(), [
                'user_email' => $authDTO->email
            ]);
            
            // Al usuario le decimos que hubo un error interno pero seguro
            throw new AuthDomainException('UNEXPECTED_ERROR', 500);
        }
    }

    /**
     * Maneja el incremento de errores sin detener el flujo principal de excepción
     */
    private function manejarFalloAutenticacion($user): void
    {
        try {
            $nuevosIntentos = $user->intentos_fallidos + 1;
            $minutosBloqueo = 0;

            if ($nuevosIntentos % 5 === 0) {
                $potencia = $nuevosIntentos / 5;
                $minutosBloqueo = 5 * (2 ** ($potencia - 1));
            }

            $this->userRepository->incrementearIntentosFallidos(
                $user->email, 
                $nuevosIntentos, 
                $minutosBloqueo
            );
        } catch (Throwable $e) {
            // Si falla la DB al registrar el error, lo logueamos pero no 
            // interrumpimos la respuesta 401 que viene después.
            Log::warning("No se pudo actualizar intentos fallidos para: " . $user->email);
        }
    }
}