<?php

namespace App\Domain\Interfaces;

use App\Domain\Entities\Auth\UserEntity;
use App\Domain\ValueObjects\EmailValueObject;

interface UserRepositoryInterface {
    //Interfaz donde el domnio habla sin saber como se implementa

    public function save(UserEntity $user): void;
    public function findByEmail(string $email): ?UserEntity;
    public function findById(int $id): ?UserEntity;
}