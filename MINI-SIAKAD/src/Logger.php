<?php
// src/Logger.php
final class Logger {
  public static function info(string $message): void {
    $dir = __DIR__ . '/../storage';
    if (!is_dir($dir)) mkdir($dir, 0777, true);

    $line = '[' . date('Y-m-d H:i:s') . '] ' . $message . "\n";
    file_put_contents($dir . '/app.log', $line, FILE_APPEND | LOCK_EX);
  }
}
