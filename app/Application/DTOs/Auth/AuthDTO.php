<?php

namespace App\Application\DTOs\Auth;
use App\Application\Validators\InputEmptys;

class AuthDTO
{
    //! Readonly es una propiedad que no se puede modificar, solo se asigna y solo se puede leer
    public function __construct(
        public readonly string $email,
        public readonly string $password
    ) {
        $email = strtolower(trim($email));
        $password = trim($password);

        InputEmptys::validate([
            'email' => $email,
            'password' => $password,
        ]);

        $this->email = $email;
        $this->password = $password;
    }

    //*Metodo que recibe un array desordenado y lo ordena accediendo a sus propiedades
    public static function fromRequest(array $requestData): self
    {

        //* Asignamos los valores al constructor con el metodo self llamando la clase
        return new self(
            $requestData['email'] ?? '',
            $requestData['password'] ?? ''
        );
    }
}
