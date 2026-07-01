<?php
// src/NoteRepo.php
final class NoteRepo {
  public static function add(PDO $pdo, int $studentId, string $title, string $content): bool {
    $title = trim($title);
    $content = trim($content);
    if ($title === '' || $content === '') return false;

    // TODO: INSERT INTO notes(...) prepared statement
    $sql = "INSERT INTO notes (student_id, title, content) VALUES (:student_id, :title, :content)";
    $stmt = $pdo->prepare($sql);
    
    return $stmt->execute([
      ':student_id' => $studentId,
      ':title'      => $title,
      ':content'    => $content
    ]);
  }

  public static function listForStudent(PDO $pdo, int $studentId, int $limit=10): array {
    // TODO: SELECT ... ORDER BY id DESC LIMIT :lim
    $sql = "SELECT id, title, content, created_at FROM notes WHERE student_id = :student_id ORDER BY id DESC LIMIT :limit";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':student_id', $studentId, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll();
  }
}
