<?php
// src/Validator.php
// TODO (PBL): pastikan regex sesuai aturan yang diminta di dokumen PBL
final class Validator {
  public static function isValidNim(string $nim): bool {
    // Aturan: NIM hanya angka 3–10 digit
    return preg_match('/^[0-9]{3,10}$/', $nim) === 1;
  }

  public static function isValidEmail(string $email): bool {
    // Validasi email sederhana
    return preg_match('/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/', $email) === 1;
  }

  public static function isValidPhone(string $phone): bool {
    // Aturan: diawali 0 atau +62
    return preg_match('/^(\+62|0)[0-9]{8,14}$/', $phone) === 1;
  }

}
