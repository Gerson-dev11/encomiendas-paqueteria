<?php

namespace App\Application\UseCases\Auth;

use App\Application\DTOs\Auth\AuthDTO;
use App\Domain\Entities\Auth\UserEntity;
use App\Domain\Interfaces\UserRepositoryInterface;

final class LoginUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    /**
     * Orquesta el proceso de login
     *
     * Flujo:
     * 1️⃣ Validar input (nivel aplicación)
     * 2️⃣ Buscar usuario
     * 3️⃣ Verificar credenciales
     * 4️⃣ Verificar reglas del dominio
     * 5️⃣ Retornar entidad autenticada
     */
    public function execute(AuthDTO $dto): UserEntity {
        // 1️⃣ Validaciones de aplicación (NO dominio)
        if (trim($dto->email) === '' || trim($dto->password) === '') {
            throw new \InvalidArgumentException('Email y contraseña son requeridos');
        }

        // 2️⃣ Buscar usuario
        $user = $this->userRepository->findByEmail($dto->email);

        if (!$user) {
            throw new \DomainException('Credenciales inválidas');
        }

        // 3️⃣ Verificar contraseña (infra-neutral)
        if (!password_verify($dto->password, $user->passwordHash())) {
            throw new \DomainException('Credenciales inválidas');
        }

        // 4️⃣ Reglas del dominio
        if (!$user->canLogin()) {
            throw new \DomainException('El usuario no puede iniciar sesión');
        }

        // 5️⃣ Usuario autenticado (a nivel dominio)
        return $user;
    }
}
