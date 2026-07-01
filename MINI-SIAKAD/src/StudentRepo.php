<?php
// src/StudentRepo.php
require_once __DIR__ . '/Validator.php';

final class StudentRepo {
  // TODO (PBL): implementasi CRUD minimal

  public static function create(PDO $pdo, string $nim, string $name, string $email, ?string $phone): int {
    // Validasi regex (wajib)
    if (!Validator::isValidNim($nim) || !Validator::isValidEmail($email)) return 0;
    if ($phone !== null && $phone !== '' && !Validator::isValidPhone($phone)) return 0;

    // TODO: prepared statement insert

    $sql = "INSERT INTO students (nim, name, email, phone) VALUES (:nim, :name, :email, :phone)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
      ':nim' => $nim,
      ':name' => $name,
      ':email' => $email,
      ':phone' => $phone
    ]);

    // return lastInsertId
    return (int)$pdo->lastInsertId();
  }

  public static function findByNim(PDO $pdo, string $nim): ?array {
    // TODO: SELECT * FROM students WHERE nim=:nim
    $sql = "SELECT * FROM students WHERE nim = :nim";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':nim' => $nim]);
    $result = $stmt->fetch();
    
    return $result ? $result : null;
  }

  public static function list(PDO $pdo): array {
    // TODO: SELECT nim,name,email,phone FROM students ORDER BY nim
    $sql = "SELECT nim, name, email, phone FROM students ORDER BY nim";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
  }
}
