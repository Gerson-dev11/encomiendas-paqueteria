<?php

namespace App\Domain\Policies;

use App\Domain\ValueObjects\EmailValueObject;

final class EmailPolicy{
    /**
     * Lista de dominios permitidos por el negocio
     * Esto es una POLÍTICA, no una verdad del dominio
     */
    private const ALLOWED_DOMAINS = [
        'gmail.com',
        'outlook.com',
        'hotmail.com',
    ];

    /**
     * Determina si un email puede ser utilizado
     * según las reglas del negocio
     */
    public function isAllowed(EmailValueObject $email): bool {
        // Extrae el dominio del email
        $domain = substr(
            strrchr($email->value(), '@'),
            1
        );

        // Valida contra la política definida
        return in_array(
            $domain,
            self::ALLOWED_DOMAINS,
            true
        );
    }
}
