<?php

namespace App\Domain\Entities\Auth;

/**
 * Entidad de Permisos segun roles
 * ENTITY (PermissionsRoleEntity)
 */

class PermissionsRoleEntity {

    private int $roleId;

    /** @var PermissionsEntity[] */
    private array $permissions = [];

    public function __construct(int $roleId) {

        //Validacion para asignacion correcta
        if($roleId <= 0){
            throw new \DomainException('Invalid role ID');
        }

        $this->roleId = $roleId;

    }

    /**
     * FACTORY para rehidratar desde DB u otra fuente
     */
    public static function rehydrate(
        int $roleId,
        array $permissions
    ): self {
        $instance = new self($roleId);
        
        foreach ($permissions as $permission) {
            $instance->attachPermission($permission);
        }

        return $instance;
    }

    /**
     * Regla del negocio para asignar permisos
     */
    public function attachPermission(PermissionsEntity $permission): void {
        if ($this->hasPermission($permission->slug())) {
            throw new \DomainException('Permission already assigned to role');
        }

        $this->permissions[] = $permission;

    }

    /**
     * Regla de negocio para remover permiso
     */
    public function detachPermission(string $slug): void
    {
        if (!$this->hasPermission($slug)) {
            throw new \DomainException('Permission not assigned to role');
        }

        $this->permissions = array_filter(
            $this->permissions,
            fn (PermissionsEntity $p) => $p->slug() !== $slug
        );
    }

    /**
     * Regla de negocio para verificación
     */
    public function hasPermission(string $slug): bool
    {
        foreach ($this->permissions as $permission) {
            if ($permission->matches($slug)) {
                return true;
            }
        }

        return false;
    }

    //ACCESO
    public function roleId(): int { return $this->roleId; }

    /**
     * @return PermissionsEntity[]
     */
    public function permissions(): array { return $this->permissions; }
}