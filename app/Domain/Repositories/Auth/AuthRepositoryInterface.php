<?php

interface AuthRepositoryInterface
{
    public function findByEmail(string $email);

    public function resetearIntentosFallidos(string $email): void;

    public function incrementearIntentosFallidos(string $email, int $intentos, int $minutos): void;

    public function saveOtpData(array $data): void;
}
