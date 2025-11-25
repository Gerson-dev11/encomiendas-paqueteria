<?php

namespace App\Domain\Entities;

class AuthEntity
{
    private int $userId;
    private string $email;
    private string $token_otp;
    private string $otp;

    public function __construct(
        int $userId,
        string $email,
        string $token_otp,
        string $otp
    ) {
        $this->userId = $userId;
        $this->email = $email;
        $this->token_otp = $token_otp;
        $this->otp = $otp;
    }

    public function getUserId(): int {return $this->userId;}

    public function getEmail(): string {return $this->email;}

    public function getTokenOtp(): string {return $this->token_otp;}

    public function getOtp(): string {return $this->otp;}
}
