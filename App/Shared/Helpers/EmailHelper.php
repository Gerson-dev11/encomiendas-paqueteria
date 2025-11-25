<?php

namespace App\Shared\Helpers;

class EmailHelper
{
    public static function validateEmail(string $email) : bool {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }
}