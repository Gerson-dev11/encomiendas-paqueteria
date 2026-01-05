<?php

namespace App\Application\DTOs\Auth;

class AuthDTO
{
    //! readonly es una propiedad que no se puede modificar, solo se asigna y solo se puede leer
    public function __construct(
        public readonly string $email,
        public readonly string $password
    ) {}

    // metodo que recibe un array desordenado y lo ordena accediendo a sus propiedades
    public static function fromRequest(array $requestData): self
    {
        return new self(
            $requestData['email'] ?? '',
            $requestData['password'] ?? ''
        );
    }
}
