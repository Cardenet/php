<?php
namespace user\model;

class User {

    public function __construct(
        private ?int $id=0, 
        private ?string $username=null, 
        private ?string $password=null, 
        private ?string $role=null 
    ) { }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getUsername(): ?string {
        return $this->username;
    }

    public function setUsername(string $username): void {
        $this->username = $username;
    }

    public function getPassword(): ?string {
        return $this->password;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }

    public function getRole(): ?string {
        return $this->role;
    }

    public function setRole(string $role): void {
        $this->role = $role;
    }

    public function __toString() {
        return sprintf(
                "User{[id=%d][username=%s][password=%s][role=%s]}", 
                $this->id, $this->username, $this->password, $this->role
            );
    }

}