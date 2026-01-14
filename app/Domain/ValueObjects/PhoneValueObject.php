<?php

namespace App\Domain\ValueObjects;

use App\Domain\Policies\PhoneValidationPolicy;
use DomainException;

final class PhoneValueObject {
    /**
     * Valor inmutable del teléfono
     */
    private string $value;

    /**
     * Constructor
     * Se encarga de:
     * - Normalizar el valor
     * - Validar reglas INVARIANTES del dominio
     * - Evitar estados inválidos
     */
    public function __construct(
        string $rawValue,
        PhoneValidationPolicy $policy
    ) {
        // El dominio NO confía en input externo
        $normalized = $policy->normalize($rawValue);

        // Regla invariante del dominio
        if (!$policy->validate($normalized)) {
            throw new DomainException('Invalid phone number for given country');
        }

        $this->value = $normalized;
    }

    // Devuelve el valor primitivo (solo lectura)
    public function value(): string {
        return $this->value;
    }

    // Comparación por VALOR
    public function equals(self $other): bool {
        return $this->value === $other->value;
    }
}
