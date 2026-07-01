<?php
require_once __DIR__ . '/../src/Db.php';
require_once __DIR__ . '/../src/StudentRepo.php';
require_once __DIR__ . '/../src/AttachmentRepo.php';
require_once __DIR__ . '/../src/Logger.php';
require_once __DIR__ . '/_layout.php';

$pdo = Db::pdo();
$nim = $_GET['nim'] ?? ($_POST['nim'] ?? '');
$msg = '';
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nim = $_POST['nim'] ?? '';
  $st = StudentRepo::findByNim($pdo, $nim);
  if (!$st) {
    $err = "Mahasiswa tidak ditemukan.";
  } else {
    // Untuk template: upload via browser belum diimplementasikan (saveUploadedFile TODO).
    // Gunakan cara sederhana: simpan konten teks dari textarea sebagai "lampiran".
    $filename = $_POST['filename'] ?? 'lampiran.txt';
    $content = $_POST['content'] ?? '';

    $ok = AttachmentRepo::addFromString($pdo, (int)$st['id'], $nim, $filename, $content);
    if ($ok) {
      Logger::info("Upload (string) nim={$nim} filename={$filename}");
      $msg = "Lampiran tersimpan.";
    } else {
      $err = "Gagal simpan lampiran (cek AttachmentRepo).";
    }
  }
}

layout_header('Upload Lampiran');
?>
<div class="card">
  <h2>Upload Lampiran</h2>
  <?php if ($msg): ?><p style="color:green;"><b><?= htmlspecialchars($msg) ?></b></p><?php endif; ?>
  <?php if ($err): ?><p style="color:red;"><b><?= htmlspecialchars($err) ?></b></p><?php endif; ?>

  <form method="post">
    <div class="row">
      <div class="col">NIM<br><input name="nim" value="<?= htmlspecialchars($nim) ?>" required></div>
      <div class="col">Nama File<br><input name="filename" value="lampiran.txt" required></div>
    </div>
    <div class="row">
      <div class="col">Isi Lampiran (simulasi)<br>
        <textarea name="content" rows="5" required>Contoh isi lampiran...</textarea>
      </div>
    </div>
    <p><button class="btn" type="submit">Simpan Lampiran</button></p>
  </form>
</div>
<?php layout_footer(); ?>
