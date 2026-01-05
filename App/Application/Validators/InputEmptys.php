<?php

namespace App\Application\Validators;

use Illuminate\Validation\ValidationException;

class InputEmptys
{
    /**
     * Valida que todos los campos del array no estén vacíos.
     *
     * @param array $data
     * @throws ValidationException
     */
    public static function validate(array $data): void
    {
        foreach ($data as $key => $value) {
            if (blank($value)) {
                throw ValidationException::withMessages([
                    $key => ["El campo '$key' no puede estar vacío."]
                ]);
            }
        }
    }
}