<?php

namespace App\Application\Validators;

class InputEmptys
{
    //* Valida que ningún campo del array esté vacío */
    public static function validate(array $data): void
    {
        //* Recorremos el array y validamos cada campo sin depender de laravel para no romper DDD */
        foreach ($data as $key => $value) {
            if ($value === null || trim($value) === '') {
                throw new \InvalidationException("EL campo '$key' no puede estar vacío");
            }
        }
    }
}
