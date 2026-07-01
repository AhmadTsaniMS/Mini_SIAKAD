<?php
// src/GradeRepo.php
require_once __DIR__ . '/GradeService.php';

final class GradeRepo {
  public static function add(PDO $pdo, int $studentId, int $courseId, int $score): bool {
    $letter = GradeService::letter($score);
    if ($letter === 'INVALID') return false;

    $sql = "INSERT INTO grades (student_id, course_id, score, letter) VALUES (:student_id, :course_id, :score, :letter)";
    $stmt = $pdo->prepare($sql);
    // TODO: INSERT INTO grades(...) prepared statement
    return $stmt->execute([
      ':student_id' => $studentId,
      ':course_id'  => $courseId,
      ':score'      => $score,
      ':letter'     => $letter
    ]);
  }
 
  public static function listForStudent(PDO $pdo, int $studentId): array {
    // TODO: JOIN courses untuk menampilkan code,name,sks + score,letter
    $sql = "SELECT c.code, c.name, c.sks, g.score, g.letter 
            FROM grades g 
            JOIN courses c ON g.course_id = c.id 
            WHERE g.student_id = :student_id 
            ORDER BY c.code ASC";
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':student_id' => $studentId]);
    return $stmt->fetchAll();
  }
}
