<?php

namespace App\Application\UseCases\Auth;

use App\Application\DTOs\Auth\AuthDTO;
use App\Domain\Exceptions\Auth\AuthDomainException;
use App\Domain\Repositories\OTPRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class AuthOTPUseCase
{
    public function __construct(private OTPRepositoryInterface $otpRepository) {}

    /**
     * @throws AuthDomainException
     */
    public function execute(OTPDTO $otpDTO): string
    {
        try {
            // 1. Intento de búsqueda del OTP (Infraestructura)
            $otpEntity = $this->otpRepository->findByOtpToken($otpDTO->otp_token);
        } catch (Throwable $e) {
            // Error de conexión a DB, tabla no existe, etc.
            Log::error("Error de infraestructura al buscar OTP: " . $e->getMessage());
            throw new AuthDomainException('SERVICE_UNAVAILABLE', 503);
        }

        // 2. Validación de existencia
        if (! $otpEntity) {
            throw new AuthDomainException('INVALID_OTP_TOKEN', 401);
        }

        // 3. Validación del OTP
        if (! $otpEntity->validateOtp($otpDTO->otp)) {
            // Actualizar intentos fallidos en repositorio
            try {
                $this->otpRepository->updateAttempts(
                    $otpDTO->otp_token,
                    $otpEntity->getAttempts()
                );
            } catch (Throwable $e) {
                Log::error("Error actualizando intentos OTP: " . $e->getMessage());
            }

            throw new AuthDomainException('INVALID_OTP', 401);
        }

        // --- FLUJO DE ÉXITO ---

        try {
            // 4. Eliminar el OTP usado
            $this->otpRepository->deleteByOtpToken($otpDTO->otp_token);
        } catch (Throwable $e) {
            Log::error("Error eliminando OTP usado: " . $e->getMessage());
            throw new AuthDomainException('SERVICE_UNAVAILABLE', 503);
        }

        // 5. Generar token de sesión (JWT, Sanctum, etc.)
        // Aquí asumimos que se genera un token simple por simplicidad
        $sessionToken = Str::random(60);

        return $sessionToken;
        
    }

}