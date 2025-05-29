<?php

namespace App\Core\Entities;

use DateTime;

class User {
    private int $id;
    private string $email;
    private string $username;
    private string $firstname;
    private string $lastname;
    private string $password;
    private ?string $mfaCode;
    private ?DateTime $mfaExpiry;
    private bool $isVerify;
    private DateTime $createdAt;

    public function __construct(
        int $id, string $email, string $username,
        string $firstname, string $lastname, string $password,
        ?string $mfaCode, bool $isVerify, ?DateTime $createdAt
    ){
        $this->id = $id;
        $this->email = $email;
        $this->username = $username;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->password = $password;
        $this->mfaCode = $mfaCode;
        $this->isVerify = $isVerify;
        $this->createdAt = $createdAt;
    }

    public function getId(): int {  return $this->id ; }
    public function getEmail(): string { return $this->email; }
    public function getUsername(): string { return $this->username; }
    public function getFirstname(): string { return $this->firstname; }
    public function getLastname(): string { return $this->lastname; }
    public function getPassword(): string { return $this->password; }
    public function getMfaCode(): string { return $this->mfaCode; }
    public function isVerify(): bool { return $this->isVerify; }
    public function getCreatedAt(): DateTime { return $this->createdAt; }
}