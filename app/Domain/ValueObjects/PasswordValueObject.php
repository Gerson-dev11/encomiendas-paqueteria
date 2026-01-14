<?php

namespace App\Domain\ValueObjects;

final class PasswordValueObject {

    /**
     * Valor interno del password
     * 🔒 Inmutable: nunca se modifica después del constructor
     */

    private string $hash;

    /**
     * Fabrica del password desde texto plano
     * Se encarga de:
     * - Normalizar el valor
     * - Permitar valores mayores a x caracteres
     */
    public static function fromPlain(string $plain): self {

        //Normalización el dominio NO confía en inputs externos
        //fromPlain se usa cuando el usuario aporta texto plano (normaliza y hashea); 

        $plain = trim($plain);

        if (strlen($plain) < 8) {
            throw new \DomainException('Password must be at least 8 characters long');
        }

        return new self(password_hash($plain, PASSWORD_DEFAULT));
    }

    /**
     * rehidratacion des de la base de datos
     * significa construir el ValueObject a partir del valor que 
     * ya existe en la base de datos (el hash), sin volver a validar ni volver a hashear. 
     * fromHash se usa cuando lees el campo password de la tabla y quieres representar ese valor en el dominio tal cual.
     */
    public static function fromHash(string $hash): self {
        return new self($hash);
    }

    //Metodo de verificacion de password
    public function verify(string $plain): bool {
        return password_verify($plain, $this->hash);
    }

    /**
     * Devuelve el valor primitivo
     * (solo lectura)
     */
    public function value(): string {
        return $this->hash;    
    }
}