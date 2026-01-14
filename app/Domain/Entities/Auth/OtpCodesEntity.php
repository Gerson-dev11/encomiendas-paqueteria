<?php

namespace App\Domain\Entities\Auth;

final class OtpCodesEntity {

    /**
     * Regla del negocio
     * Un codigo otp puede fallar x numero de veces
     * Pero aqui somos profesionales y confiamos que el usuario no se equivoque XD
     */

    private const MAX_ATTEMPTS = 1; //PAJA esto se cambia segun coveniencia xd

    //Identidad de la entidad
    private int $id;

    //Usuario al que le pertenece el otp
    private int $userId;

    /**
     * parametros del otp
     * esto no debe de exponerse ni modificarse
     * Se puece cambiar tambien a conveniencia 
     */

    private string $codeHash;

    //Fecha de expiracion del otp
    private \DateTimeImmutable $expiresAt;

    //Cantidad de intentos fallidos
    private int $attempts;

    /**
     * Fechaa de uso
     * Null = no usado
     */

    private ?\DateTimeImmutable $usedAt;

    //Fecha de creacion
    private \DateTimeImmutable $createdAt;

    /**
     * Contructor privado para forzar uso de factory controladas
     */

    private function __construct(

        int $id,
        int $userId,
        string $codeHash,
        \DateTimeImmutable $expiresAt,
        int $attempts,
        ?\DateTimeImmutable $usedAt,
        \DateTimeImmutable $createdAt
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->codeHash = $codeHash;
        $this->expiresAt = $expiresAt;
        $this->attempts = $attempts;
        $this->usedAt = $usedAt;
        $this->createdAt = $createdAt;
    }

    /**
     * Factories
     */

    //Funcion para crear un nuevo otp
    public static function create(
        int $userId,
        string $codeHash,
        \DateTimeImmutable $expiresAt
    ) : self {
        return new self(
            id: 0, //ID se asigna en persistencia
            userId: $userId,
            codeHash: $codeHash,
            expiresAt: $expiresAt,
            attempts: 0, //Intentos
            usedAt: null, //No usado
            createdAt: new \DateTimeImmutable() //creacion ahora
        );
    }

    /**
    * Rehidrata = volver a convertir datos muertos en un objeto vivo de dominio. la entidad desde la base de datos
    * Basicamente se encarga de persitir los datos y devolver la entidad completa
    * Ya que la base de datos no conoce las reglas de negocio
    */
    public static function fromPersistence(
        int $id,
        int $userId,
        string $codeHash,
        \DateTimeImmutable $expiresAt,
        int $attempts,
        ?\DateTimeImmutable $usedAt,
        \DateTimeImmutable $createdAt
    ): self {
        return new self(
            $id,
            $userId,
            $codeHash,
            $expiresAt,
            $attempts,
            $usedAt,
            $createdAt
        );
    }

    //Comportamiento de dominio

    //Determinar si el otp puede intentar validarse

    public function canBeValidated(): bool {
        return !$this->isExpired()
            && $this->isUsed()
            && $this->attempts < self::MAX_ATTEMPTS;
    }

    /**
     * Intentar calidar el OTP
     * Incrementa si falla
     * Marcar usado si es correcto
     * No devolver valores booleanos para evitar fugas de informacion
     */

    public function validateCode(string $plainCode, callable $hasher): void {
        if(!$this->canBeValidated()) {
            throw new \DomainException('OTP cannot be validated');
        }

        if(!$hasher($plainCode, $this->codeHash)) {
            $this->attempts++;
            throw new \DomainException('Invalid OTP code');
        }

        //Marcar si due exitoso
        $this->usedAt = new \DateTimeImmutable();
}

//Reglas del OTP

//Verificar expiracion de codigo
    public function isExpired(): bool {
        $now = new \DateTimeImmutable();
        //Validamos si la fecha actual es mayor a la de expiracion
        return $now > $this->expiresAt;
    }

    //Verificar si el codigo ya fue usado
    public function isUsed(): bool {
        return $this->usedAt !== null;
    }

    //Invariantes

    //Validadcion de parametros que no debe de romperse o cambiarse
    public function validatedInvariants(
        \DateTimeImmutable $expiresAt,
        int $attempts,
        \DateTimeImmutable $createdAt
    ) : void {
        if ($expiresAt <= $createdAt) {
            throw new \DomainException('OTP expiration must be after creation date');
    }

    if ($attempts < 0 || $attempts > self::MAX_ATTEMPTS) {
        throw new \DomainException('Invalid number of OTP attempts');
    }
}

//Los metodos de acceso para leer los valores
    public function userId(): int { return $this->userId; }

    public function attempts(): int { return $this->attempts; }

    public function expiresAt(): \DateTimeImmutable { return $this->expiresAt; }

    public function usedAt(): ?\DateTimeImmutable { return $this->usedAt; }

}