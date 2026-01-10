<?php

namespace App\Domain\Entities\Auth;

/**
 * 
 * ENTITY (UserEntity)
 * Es dominio puro.
 * Su trabajo es
 * Proteger reglas
 * Evitar estados inválidos
 * Encapsular comportamiento
 * Representar al usuario como concepto de negocio
 * Por eso SOLO tiene:
 * 
 * id
 * fullName
 * Evitar estados inválidos
 * Encapsular comportamiento
 * Representar al usuario como concepto de negocio
 * 
 * Por eso solo tiene
 * id
 * fullName
 * email
 * passwordHash
 * isActive
 * emailVerifiedAt 
 */


class UserEntity {

        //Todo: Estos datos son los que la entity debe manejar y encapsular Entity ≠ Base de Datos (Migrations)
        private int $id;
        //Parametros de identidad del usuario
        private string $fullName;
        private string $email;
        //Parametros de auth que se manejan con Laravel (Sactum, Resdis, etc)
        private string $passwordHash;
        private \DateTimeImmutable|null $emailVerifiedAt;
        //Estado de la actividad del usuario
        private bool $isActive;


    public function __construct(
        int $id,
        string $fullName,
        string $email,
        string $passwordHash,
        ?\DateTimeImmutable $emailVerifiedAt,
        bool $isActive,
    )
    {
        //$this->validateFullName($fullName);

        $this->id = $id;
        $this->fullName = $fullName;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->emailVerifiedAt = $emailVerifiedAt;
        $this->isActive = $isActive;
    }

    /**
     * ¿Que hace un Factory en una Entity?
     * Crea un usuario nuevo, no uno cargado desde BD
     * Define reglas de nacimiento
     * 
     * id = 0 → todavía no existe en la base de datos
     * isActive = true → nace activo
     * emailVerifiedAt = null → aún no ha verificado su email
     */

//FACTORY PARA CREAR USUARIOS NUEVOS
    public static function register(
        string $fullName,
        string $email,
        string $passwordHash
    ): self {
        //Estos datos no se usan desde el exterior se deben de encapsular aqui  
        return new self(
            0, //ID temporal que luego la base de datos asignara
            $fullName, //Nombre que se debe de validar internamente
            $email, //Aqui podemos usar VALUE OBJECTS si queremos
            $passwordHash, //Contraseña hasheada
            null, //Email no verificado al inicio
            true //Usuario activo al inicio
        );
    }

    //Behavior para verificación del email
    public function verifyEmail(): void {

    //parametros para que no entre en un bucle de verificaciones
        if ($this->emailVerifiedAt !== null) {
            throw new \DomainException("El email ya ha sido verificado."); //Aqui podemos hacer uso de excepciones del negocio que podemos definir
        }

        //Marcar la fecha de verificación
        $this->emailVerifiedAt = new \DateTimeImmutable();
    }

    //Regla del negocio para desactivar usuario
    public function deactivate(): void {
        //Validar que el usuario esté activo antes de desactivarlo
        if (!$this->isActive) {
            throw new \DomainException("El usuario ya está desactivado.");
        }

        //Desactivar el usuario
        $this->isActive = false;
    }

    //Metodos para poder cambiar la contraseña del usuario
    public function changePassword(string $newHash) : void {

        //Regla para que la nueva contraseña no sea igual a la anterior
        if($newHash === $this->passwordHash) {
            throw new \DomainException("La nueva contraseña no puede ser igual a la anterior.");
        }

        //Asignar la nueva contraseña
        $this->passwordHash = $newHash;
    }

    //Regla para permitir acceso a usuarios bajo reglas 
    public function canLogin(): bool {

        //estlecemos el parametro de acceso que debe de contener active y email verificado
        return $this->isActive && $this->emailVerifiedAt !== null;
    }

    //Getters para acceder a los datos de la entity 
    //Son la única forma de leer el estado sin romperlo.
    public function id(): int { return $this->id; }
    public function email(): string { return $this->email; }
    public function passwordHash(): string { return $this->passwordHash; }


}