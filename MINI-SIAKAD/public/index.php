<?php
require_once __DIR__ . '/../src/Db.php';
require_once __DIR__ . '/../src/StudentRepo.php';
require_once __DIR__ . '/../src/CourseRepo.php';
require_once __DIR__ . '/../src/GradeRepo.php';
require_once __DIR__ . '/../src/NoteRepo.php';
require_once __DIR__ . '/../src/AttachmentRepo.php';
require_once __DIR__ . '/_layout.php';

$pdo = Db::pdo();

// TODO (PBL): setelah repo selesai, dashboard menampilkan angka yang benar
$students = StudentRepo::list($pdo);
$courses = CourseRepo::list($pdo);

layout_header('Dashboard');
?>
<div class="card">
  <h2>Dashboard</h2>
  <div class="row">
    <div class="col"><b>Total Mahasiswa</b><br><?= count($students) ?></div>
    <div class="col"><b>Total Mata Kuliah</b><br><?= count($courses) ?></div>
    <div class="col"><b>Catatan</b><br><span class="muted">Tampilkan setelah NoteRepo selesai</span></div>
    <div class="col"><b>Lampiran</b><br><span class="muted">Tampilkan setelah AttachmentRepo selesai</span></div>
  </div>
</div>

<div class="card">
  <h3>Daftar Mahasiswa</h3>
  <table>
    <tr><th>NIM</th><th>Nama</th><th>Email</th><th>Aksi</th></tr>
    <?php foreach ($students as $s): ?>
      <tr>
        <td><?= htmlspecialchars($s['nim'] ?? '') ?></td>
        <td><?= htmlspecialchars($s['name'] ?? '') ?></td>
        <td><?= htmlspecialchars($s['email'] ?? '') ?></td>
        <td><a class="btn" href="student_detail.php?nim=<?= urlencode($s['nim'] ?? '') ?>">Detail</a></td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>
<?php layout_footer(); ?>
