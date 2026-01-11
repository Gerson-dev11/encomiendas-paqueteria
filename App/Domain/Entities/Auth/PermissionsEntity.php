<?php

namespace App\Domain\Entities\Auth;

/**
 * Reglas y significado de permisos
 * ENTITY (PermissionsEntity)
 * 
 */

class PermissionsEntity {

    //Parametros que se manejan
    private int $id;
    //Nombre del permiso
    private string $name;
    //Nombre a entendimiento de maquina
    private string $slug;
    private string $group;

    public function __construct(

        int $id,
        string $name,
        string $slug,
        string $group

    )
    {
    /**
     * Aqui debemos de llamar DTOS o VALIDATORS
     */
        $this->validateName($name);
        $this->validateSlug($slug);
        $this->validateGroup($group);

        $this->id = $id;
        $this->name = $name;
        $this->slug = $slug;
        $this->group = $group;
    }

    /**
     * Factory para rehidratar desde DB u otra fuente
     */

    public static function fromPersistence(
        int $id,
        string $name,
        string $slug,
        string $group
    ): self {
        return new self($id, $name, $slug, $group);
    }

    //VALIDACIONES DE REGLA DE NEGOCIO
    private function validateName(string $name): void {
        if ($name === '' || strlen($name) > 100) {
            throw new \DomainException('Invalid permission name');
        }
    }

    private function validateSlug(string $slug): void {
        if (!preg_match('/^[a-z]+\.[a-z\.]+$/', $slug)) {
            throw new \DomainException('Invalid permission slug');
        }
    }

    private function validateGroup(string $group): void {
        if ($group === '' || strlen($group) > 50) {
            throw new \DomainException('Invalid permission group');
        }
    }

    //Behaviors son para acciones del entity, no para persistencia
    public function belongsToGroup(string $group): bool {
        return $this->group === $group;
    }

    public function matches(string $slug): bool {
        return $this->slug === $slug;
    }

    //Acceso
    public function id(): int { return $this->id; }
    public function name(): string { return $this->name; }
    public function slug(): string { return $this->slug; }
    public function group(): string { return $this->group; }
}