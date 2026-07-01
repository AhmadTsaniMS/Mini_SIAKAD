<?php
// src/AttachmentRepo.php
require_once __DIR__ . '/FileStorage.php';

final class AttachmentRepo {
  // Dipakai autograder: simpan lampiran dari string + insert metadata DB
  public static function addFromString(PDO $pdo, int $studentId, string $studentNim, string $filename, string $content): bool {
    $saved = FileStorage::saveString($studentNim, $filename, $content);

    // TODO: INSERT INTO attachments(...) prepared statement menggunakan $saved
    $sql = "INSERT INTO attachments (student_id, filename, stored_path, mime, size_bytes) 
            VALUES (:student_id, :filename, :stored_path, :mime, :size_bytes)";
    $stmt = $pdo->prepare($sql);
    
    return $stmt->execute([
      ':student_id'  => $studentId,
      ':filename'    => $filename,
      ':stored_path' => $saved['stored_path'],
      ':mime'        => $saved['mime'],
      ':size_bytes'  => $saved['size_bytes']
    ]);
  }

  public static function listForStudent(PDO $pdo, int $studentId, int $limit=10): array {
    // TODO: SELECT filename,stored_path,created_at ORDER BY id DESC LIMIT :lim
    $sql = "SELECT filename, stored_path, created_at FROM attachments WHERE student_id = :student_id ORDER BY id DESC LIMIT :limit";
    $stmt = $pdo->prepare($sql);
    
    // Bind value secara eksplisit sebagai tipe integer untuk menghindari error syntax pada klausa LIMIT
    $stmt->bindValue(':student_id', $studentId, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll();
  }

  public static function countForStudent(PDO $pdo, int $studentId): int {
    // TODO: SELECT COUNT(*)
    $sql = "SELECT COUNT(*) FROM attachments WHERE student_id = :student_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':student_id' => $studentId]);
    
    // fetchColumn() digunakan untuk mengambil baris pertama dari kolom pertama hasil perhitungan
    return (int) $stmt->fetchColumn();
  }
}
