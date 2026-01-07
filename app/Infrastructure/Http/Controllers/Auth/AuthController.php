<?php

namespace App\Infrastructure\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Application\UseCases\Auth\AuthUseCase;
use App\Application\DTOs\Auth\AuthDTO;
use App\Domain\Exceptions\Auth\AuthDomainException;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private AuthUseCase $authUseCase) {}

    public function login(Request $request): JsonResponse
    {
        try {
            // 1. Validar inputs básicos y crear DTO
            $dto = new AuthDTO(
                email: $request->input('email'),
                password: $request->input('password')
            );

            // 2. Ejecutar el caso de uso
            $otpToken = $this->authUseCase->execute($dto);

            // 3. Respuesta de éxito (Enviamos el otp_token en una cookie segura)
            return response()
                ->json([
                    'message' => 'Credenciales válidas. Verifique su correo para el código OTP.',
                    'next_step' => 'verify_otp'
                ])
                ->cookie('otp_token', $otpToken, 15, null, null, true, true);

        } catch (AuthDomainException $e) {
            // Este catch captura TODO lo que definiste en el UseCase:
            // - Credenciales inválidas (401)
            // - Bloqueos (403)
            // - Errores de Infraestructura/Postgres (500/530)
            
            return response()->json([
                'error' => $e->getMessage(),
                'meta' => $e->getMetadata() // Si guardaste minutos de bloqueo, etc.
            ], $e->getCode() ?: 400);

        } catch (\Throwable $e) {
            // Fallo crítico no controlado (Panic room)
            \Log::critical("Fallo total en login: " . $e->getMessage());
            
            return response()->json([
                'error' => 'INTERNAL_SERVER_ERROR'
            ], 500);
        }
    }
}