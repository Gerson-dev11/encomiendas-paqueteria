<?php

namespace App\Domain\Policies;

final class ElSalvadorPhonePolicy implements PhoneValidationPolicy {

    public function normalize(string $phone): string {

        $phone = trim($phone);
        $phone = preg_replace('/\s+/', '', $phone);

        if (!str_starts_with($phone, '+503')) {
            $phone = '+503' . $phone;        
        }

        return $phone;
    }
    public function validate(string $phone): bool {
        return preg_match('/^\+503[267]\d{7}$/', $phone) === 1;
    }
}