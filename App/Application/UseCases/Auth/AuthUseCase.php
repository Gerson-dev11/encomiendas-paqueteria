<?php

namespace App\Application\UseCases\Auth;

use App\Application\DTOs\Auth\AuthDTO;
use App\Domain\Repositories\UserRepositoryInterface;

class AuthUseCase
{
    public function __construct(private UserRepositoryInterface $userRepository) {}

    // * Ejecuta el caso de uso de autenticación */
    public function execute(AuthDTO $authDTO): array
    {

        // * Buscamos por correo eletrónico desde el repositorio */
        $user = $this->userRepository->findByEmail($authDTO->email);

        //* Si no existe el usuario, lanzamos excepción */
        if (! $user) {
            throw new \Exception('Credenciales inválidas', 401);
        }
        // * si no existe el usuario o la contraseña es incorrecta, lanzamos excepción */
        if (! Hash::check($authDTO->password, $user->password_hash)) {
            $this->userRepository->incrementearIntentosFallidos($authDTO->email);
            throw new Exception('Credenciales inválidas', 401);
        }

        // * Si el admin ha bloqueado la cuenta o está temporalmente bloqueada */
        if ($user->cuenta_bloqueada) {
            throw new Exception('La cuenta está bloqueada. Contacte al administrador.', 403);
        }

        // * Tiempo bloqueado por intentos fallidos */
        if ($user->tiempo_bloqueado && $user->tiempo_bloqueado > now()) {
            $bloqueadodurante = $user->tiempo_bloqueado->diffForHumans(now(), true);
            throw new Exception("La cuenta está temporalmente bloqueada. Intente nuevamente en $bloqueadodurante.", 403);
        }

        // * retornamos los datos del usuario como array */
        return $user->toArray();

    }
}
