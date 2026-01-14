<?php

namespace App\Domain\Policies;

final class UsaPhonePolicy implements PhoneValidationPolicy {

    public function normalize(string $phone): string {

        $phone = trim($phone);
        $phone = preg_replace('/\D+/', '', $phone);

        if (!str_starts_with($phone, '1')) {
            $phone = '1' . $phone;
        }

        return '+' . $phone;
    }

    public function validate(string $phone): bool {
        return preg_match('/^\+1[2-9]\d{2}[2-9]\d{6}$/', $phone) === 1;
    }
}