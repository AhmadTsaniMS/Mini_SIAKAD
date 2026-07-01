<?php
// src/FileStorage.php
final class FileStorage {
  // Dipakai autograder: simpan "file" dari string
  public static function saveString(string $studentNim, string $filename, string $content): array {
    $safeName = basename($filename);
    $dir = __DIR__ . '/../storage/uploads/' . $studentNim;
    if (!is_dir($dir)) mkdir($dir, 0777, true);

    $path = $dir . '/' . $safeName;
    file_put_contents($path, $content, LOCK_EX);

    return [
      'stored_path' => 'storage/uploads/' . $studentNim . '/' . $safeName,
      'size_bytes' => filesize($path),
      'mime' => 'text/plain',
    ];
  }

  // TODO (UI): implementasi upload asli (move_uploaded_file) jika ingin fitur upload via browser
  public static function saveUploadedFile(string $studentNim, array $file): ?array {
    // $file format: $_FILES['file']
    if (!isset($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) {
      return null;
    }
 
    $safeName = basename($file['name']);
    $dir = __DIR__ . '/../storage/uploads/' . $studentNim;
    if (!is_dir($dir)) mkdir($dir, 0777, true);
 
    $path = $dir . '/' . $safeName;
    
    if (move_uploaded_file($file['tmp_name'], $path)) {
      return [
        'stored_path' => 'storage/uploads/' . $studentNim . '/' . $safeName,
        'size_bytes'  => filesize($path),
        'mime'        => mime_content_type($path) ?: 'application/octet-stream',
      ];
    }
    
    return null;
  }
}
