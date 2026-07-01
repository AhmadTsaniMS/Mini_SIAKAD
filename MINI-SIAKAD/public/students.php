<?php
require_once __DIR__ . '/../src/Db.php';
require_once __DIR__ . '/../src/StudentRepo.php';
require_once __DIR__ . '/../src/Logger.php';
require_once __DIR__ . '/_layout.php';

$pdo = Db::pdo();
$msg = '';
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nim = $_POST['nim'] ?? '';
  $name = $_POST['name'] ?? '';
  $email = $_POST['email'] ?? '';
  $phone = $_POST['phone'] ?? '';

  $id = StudentRepo::create($pdo, $nim, $name, $email, $phone);
  if ($id > 0) {
    Logger::info("Create student {$nim}");
    $msg = "Mahasiswa berhasil ditambahkan.";
  } else {
    $err = "Gagal menambah mahasiswa (cek validasi/SQL).";
  }
}

$students = StudentRepo::list($pdo);

layout_header('Mahasiswa');
?>
<div class="card">
  <h2>Mahasiswa</h2>
  <?php if ($msg): ?><p style="color:green;"><b><?= htmlspecialchars($msg) ?></b></p><?php endif; ?>
  <?php if ($err): ?><p style="color:red;"><b><?= htmlspecialchars($err) ?></b></p><?php endif; ?>
  <h3>Tambah Mahasiswa</h3>
  <form method="post">
    <div class="row">
      <div class="col">NIM<br><input name="nim" required></div>
      <div class="col">Nama<br><input name="name" required></div>
    </div>
    <div class="row">
      <div class="col">Email<br><input name="email" required></div>
      <div class="col">HP<br><input name="phone"></div>
    </div>
    <p><button class="btn" type="submit">Simpan</button></p>
  </form>
</div>

<div class="card">
  <h3>Daftar Mahasiswa</h3>
  <table>
    <tr><th>NIM</th><th>Nama</th><th>Email</th><th>HP</th><th>Aksi</th></tr>
    <?php foreach ($students as $s): ?>
      <tr>
        <td><?= htmlspecialchars($s['nim'] ?? '') ?></td>
        <td><?= htmlspecialchars($s['name'] ?? '') ?></td>
        <td><?= htmlspecialchars($s['email'] ?? '') ?></td>
        <td><?= htmlspecialchars((string)($s['phone'] ?? '-')) ?></td>
        <td><a class="btn" href="student_detail.php?nim=<?= urlencode($s['nim'] ?? '') ?>">Detail</a></td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>
<?php layout_footer(); ?>
