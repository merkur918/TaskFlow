<?php

class User{

    private PDO $db;
    
    public function __construct()
    {
        $this->db = Database::getConexion();
    }

   public function create($username, $email, $password)
{
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $this->db->prepare(
        "INSERT INTO users (username, email, password) VALUES (?, ?, ?)"
    );

    return $stmt->execute([$username, $email, $passwordHash]);
}

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch() ?: null;
    }

    public function findByUsername(string $username): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        return $stmt->fetch() ?: null;
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function verifyPassword(string $email, string $password): bool
    {
        $user = $this->findByEmail($email);
        return $user && password_verify($password, $user['password']);
    }
}