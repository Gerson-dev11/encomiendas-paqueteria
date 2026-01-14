<?php

namespace App\Domain\ValueObjects;

final class EmailValueObject {
    /**
     * Valor interno del email
     * 🔒 Inmutable: nunca se modifica después del constructor
     */
    private string $value;

    /**
     * Constructor
     * 
     * Se encarga de:
     * - Normalizar el valor
     * - Validar reglas INVARIANTES del dominio
     * - Evitar estados inválidos
     */
    public function __construct(string $email) {
        // Normalización: el dominio NO confía en inputs externos
        $email = strtolower(trim($email));

        // Regla INVARIANTE:
        // Si no es un email válido, NO existe como Email en el dominio
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \DomainException('Invalid email format');
        }

        $this->value = $email;
    }

    /**
     * Devuelve el valor primitivo
     * (solo lectura)
     */
    public function value(): string {
        return $this->value;
    }

    /**
     * Comparación por VALOR
     * Dos Emails son iguales si su valor es igual
     * Es una comparacion tipo Identidad vs Valor
     * En el cual nos aseguramos que el valor interno es el mismo
     */
    public function equals(self $other): bool {
        return $this->value === $other->value;
    }

    /**
     * Permite tratar el objeto como string
     * Ej: logs, debugging, concatenación
     */
    public function __toString(): string {
        return $this->value;
    }
}
