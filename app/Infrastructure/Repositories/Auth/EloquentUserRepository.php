<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Auth\UserEntity;
use App\Domain\Interfaces\UserRepositoryInterface;
use App\Models\User;

final class EloquentUserRepository implements UserRepositoryInterface
{
    /**
     * Busca un usuario por email
     */
    public function findByEmail(string $email): ?UserEntity {
        $model = User::where('email', $email)->first();

        return $model ? $this->toEntity($model) : null;
    }

    /**
     * Busca un usuario por ID
     */
    public function findById(int $id): ?UserEntity {
        $model = User::find($id);

        return $model ? $this->toEntity($model) : null;
    }

    /**
     * Guarda un usuario
     */
    public function save(UserEntity $user): void {
        $model = $user->id() === 0
            ? new User()
            : User::find($user->id());

        $model->full_name = $user->fullName();
        $model->email = $user->email();
        $model->password = $user->passwordHash();
        $model->is_active = $user->isActive();

        $model->save();
    }

    /**
     * Traducción Eloquent → Entity
     */
    private function toEntity(User $model): UserEntity {
        return new UserEntity(
            $model->id,
            $model->full_name,
            $model->email,
            $model->password,
            $model->email_verified_at
                ? new \DateTimeImmutable($model->email_verified_at)
                : null,
            $model->is_active
        );
    }
}
