<?php
// src/CourseRepo.php
final class CourseRepo {
  public static function list(PDO $pdo): array {
    // TODO: SELECT code,name,sks FROM courses ORDER BY code
    $sql = "SELECT code, name, sks FROM courses ORDER BY code";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
  }

  public static function findByCode(PDO $pdo, string $code): ?array {
    // TODO: SELECT * FROM courses WHERE code=:code
    $sql = "SELECT * FROM courses WHERE code = :code";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':code' => $code]);
    $result = $stmt->fetch();

    return $result ? $result : null;
  }
}
