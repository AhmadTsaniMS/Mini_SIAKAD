<?php
// src/Db.php
require_once __DIR__ . '/../pbl.php';

// Koneksi PDO MySQL (gunakan env DB_* atau default di bawah)
final class Db {
  public static function pdo(): PDO {
    return SqliteBridgeManager::getPdo();
  }
}