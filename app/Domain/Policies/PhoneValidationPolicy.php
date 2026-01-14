<?php

namespace App\Domain\Policies;

interface PhoneValidationPolicy {

    public function validate(string $phone): bool;

    public function normalize(string $phone): string;

}