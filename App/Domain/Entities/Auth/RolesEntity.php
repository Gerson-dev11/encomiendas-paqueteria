<?php

namespace App\Domain\Entities\Auth;

/**
 * ENTITY (RolesEntity)
 * Creacion de reglas de negocio para Roles
 * Su trabajo es declarar las propiedades y ya
 */

class RolesEntity {

    //Unicos parametros que se manejan
    private int $id;
    private string $name;

    public function __construct(
        int $id,
        string $name,
    )
    {
        $this->id = $id;
        $this->name = $name;
    }

    //Funcion para creacion gestionada de roles
    public static function create(int $id, string $name): self {
        return new self($id, strtolower(trim($name)));
    }

    //Funcion para ver si es admin
    public function isAdmin(): bool {
        return $this->name === 'admin';
    }

    //Getters para ppoder acceder a los datos
    public function getId(): int { return $this->id; }
    public function getName(): string{ return $this->name; }

}