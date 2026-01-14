<?php

namespace App\Domain\Entities\Auth;

class AuthEntity
{
    private int $userId;
    private string $email;
    private string $otp_token;
    private string $otp;
    private \DateTimeImmutable $expiresAt;
    private int $attempts;
               
    public function __construct(
        int $userId,
        string $email,
        string $otp_token,
        string $otp,
        \DateTimeImmutable $expiresAt,
        int $attempts = 0
    ) {
        $this->userId = $userId;
        $this->email = $email;
        $this->otp_token = $otp_token;
        $this->otp = $otp;
        $this->expiresAt = $expiresAt;
        $this->attempts = $attempts;
    }

    public function isExpired(): bool
    {
        return $this->expiresAt <= new \DateTimeImmutable();
    }

    public function increaseAttempts(): void
    {
        $this->attempts++;

        if ($this->attempts >= 5) {
            throw new \DomainException("Límite de intentos alcanzado.");
        }
    }

    public function validateOtp(string $inputOtp): bool
    {
        if ($this->isExpired()) {
            throw new \DomainException("OTP expirado.");
        }

        $this->increaseAttempts();

        return hash_equals($this->otp, $inputOtp);
    }

    public function getAttempts(): int
    {
        return $this->attempts;
    }
    public function getUserId(): int
    {
        return $this->userId;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function getOtpToken(): string
    {
        return $this->otp_token;
    }
    public function getExpiresAt(): \DateTimeImmutable
    {
        return $this->expiresAt;
    }
}
