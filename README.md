# 🎓 Mini SIAKAD Lite PBL


<div align="center">

  <p align="center">
    <img src="https://img.shields.io/badge/PHP-8.0%20%7C%208.1%20%7C%208.2-777bb4?style=for-the-badge&logo=php&logoColor=white" alt="PHP Version" />
    <img src="https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL" />
    <img src="https://img.shields.io/badge/SQLite-3-003B57?style=for-the-badge&logo=sqlite&logoColor=white" alt="SQLite" />
    <img src="https://img.shields.io/badge/Architecture-Repository%20Pattern-orange?style=for-the-badge" alt="Architecture" />
  </p>

  <p align="center">
    <strong>Sistem Informasi Akademik Ringan dengan Arsitektur Berorientasi Objek (OOP) & Fault-Tolerant Hybrid Database Layer</strong>
  </p>
</div>

![GitHub repo size](https://img.shields.io/github/repo-size/ahmadtsanims/Mini_SIAKAD?style=for-the-badge)
![GitHub last commit](https://img.shields.io/github/last-commit/ahmadtsanims/Mini_SIAKAD?style=for-the-badge)

---

## 📌 Deskripsi Proyek

**Mini SIAKAD Lite PBL** adalah aplikasi *Full-Stack* berbasis PHP Native yang dikembangkan khusus untuk mensimulasikan core engine Sistem Informasi Akademik. Proyek ini menggabungkan kesederhanaan struktur monolitik dengan arsitektur backend modern seperti **Repository Pattern**, **Business Logic Isolation**, dan **Automated Data Validation**.

Fitur andalan dari sistem ini adalah **Self-Healing Hybrid Database Bridge**. Dirancang untuk kebutuhan *automated assessment* (autograder) dan CI/CD pipeline (seperti GitHub Actions), sistem ini mendeteksi gangguan pada server MySQL utama secara *real-time* dan melakukan migrasi serta *fallback* dinamis ke *In-Memory* SQLite secara instan tanpa menghentikan runtime aplikasi.

---

## ⚡ Fitur Utama & Keunggulan

### 🛡️ 1. Fault-Tolerant DB (Self-Healing)
* **Zero-Config Fallback:** Jika koneksi MySQL `PDO` terputus atau tidak terkonfigurasi, `SqliteBridgeManager` secara otomatis menginisiasi SQLite *in-memory*.
* **Dynamic Query Translation:** Menggunakan `SqlitePdoBridge` untuk meng-intercept query SQL spesifik milik MySQL (seperti `TRUNCATE TABLE` atau pengaturan `FOREIGN_KEY_CHECKS`) dan menerjemahkannya ke sintaks yang kompatibel dengan SQLite secara *on-the-fly*.
* **Auto-Schema Migration:** Secara otomatis menyusun ulang 5 tabel utama (`students`, `courses`, `grades`, `notes`, `attachments`) saat *fallback* dipicu.

### 🧩 2. Robust Backend Architecture
* **Repository Pattern:** Pemisahan total antara *raw queries* database dan pengolahan data melalui modul individual (`StudentRepo`, `CourseRepo`, `GradeRepo`, dll).
* **Regex-Based Strict Validator:** Keamanan data masukan dijamin lewat `Validator.php` dengan pengecekan format baku:
    * **NIM:** Pola numerik standar akademis.
    * **Email:** Validasi format RFC standar.
    * **Phone:** Memastikan nomor telepon hanya berisi karakter legal.
* **Automatic Grade Converter:** `GradeService` mengisolasi aturan bisnis penilaian universitas, mengubah skor angka (0-100) menjadi predikat huruf mutu akademik (`A` hingga `E`) secara otomatis.

### 📂 3. Advanced Document & Activity Management
* **Secure File Storage Wrapper:** Fitur dual-mode penyimpanan berkas lewat `FileStorage.php`. Mendukung penyimpanan string mentah dari testing otomatis (`saveString`) maupun unggahan file asli via browser form (`saveUploadedFile`).
* **Unified Logger:** Setiap operasi penting dicatat secara terpusat pada file `storage/app.log` lengkap dengan penanda waktu (*timestamp*).

---

## 🏗️ Desain & Arsitektur Sistem

### Alur Logika Koneksi Database (Self-Healing Bridge)
```text
  [ Aplikasi Dijalankan ]
           │
           ▼
 ┌──────────────────┐
 │ Mencoba Koneksi  │
 │     MySQL        │
 └──────────────────┘
           │
           ├─► Sukses ──► [ Gunakan MySQL Engine ]
           │
           └─► Gagal (Timeout/Refused)
                       │
                       ▼
         ┌──────────────────────────┐
         │ Pemicu Self-Healing      │
         │ Inisiasi SQLite In-Memory│
         └──────────────────────────┘
                       │
                       ▼
         ┌──────────────────────────┐
         │ Eksekusi Auto-Migration  │
         │   & Query Translation    │
         └──────────────────────────┘
                       │
                       ▼
         [ Aplikasi Tetap Berjalan! ]



