<?php
require_once __DIR__ . '/../src/Db.php';
require_once __DIR__ . '/../src/StudentRepo.php';
require_once __DIR__ . '/../src/GradeRepo.php';
require_once __DIR__ . '/../src/NoteRepo.php';
require_once __DIR__ . '/../src/AttachmentRepo.php';
require_once __DIR__ . '/_layout.php';

$pdo = Db::pdo();
$nim = $_GET['nim'] ?? '';

$student = StudentRepo::findByNim($pdo, $nim);
if (!$student) {
  layout_header('Detail Mahasiswa');
  echo "<div class='card'><b style='color:red;'>Mahasiswa tidak ditemukan.</b></div>";
  layout_footer();
  exit;
}

$grades = GradeRepo::listForStudent($pdo, (int)$student['id']);
$notes = NoteRepo::listForStudent($pdo, (int)$student['id'], 10);
$atts  = AttachmentRepo::listForStudent($pdo, (int)$student['id'], 10);

layout_header('Detail Mahasiswa');
?>
<div class="card">
  <h2>Detail Mahasiswa</h2>
  <p><b>NIM:</b> <?= htmlspecialchars($student['nim']) ?> &nbsp; <b>Nama:</b> <?= htmlspecialchars($student['name']) ?></p>
  <p><b>Email:</b> <?= htmlspecialchars($student['email']) ?> &nbsp; <b>HP:</b> <?= htmlspecialchars((string)($student['phone'] ?? '-')) ?></p>
</div>

<div class="card">
  <h3>Nilai</h3>
  <p class="muted">Terisi setelah GradeRepo::listForStudent() diimplementasikan.</p>
  <table>
    <tr><th>Kode</th><th>MK</th><th>SKS</th><th>Nilai</th><th>Grade</th></tr>
    <?php foreach ($grades as $g): ?>
      <tr>
        <td><?= htmlspecialchars($g['code'] ?? '') ?></td>
        <td><?= htmlspecialchars($g['name'] ?? '') ?></td>
        <td><?= (int)($g['sks'] ?? 0) ?></td>
        <td><?= (int)($g['score'] ?? 0) ?></td>
        <td><b><?= htmlspecialchars($g['letter'] ?? '') ?></b></td>
      </tr>
    <?php endforeach; ?>
  </table>
  <p><a class="btn" href="grade_form.php?nim=<?= urlencode($student['nim']) ?>">Input Nilai</a></p>
</div>

<div class="card">
  <h3>Catatan Wali</h3>
  <p class="muted">Terisi setelah NoteRepo diimplementasikan.</p>
  <ul>
    <?php foreach ($notes as $n): ?>
      <li><b><?= htmlspecialchars($n['title'] ?? '') ?></b> – <?= htmlspecialchars($n['created_at'] ?? '') ?><br>
          <?= nl2br(htmlspecialchars($n['content'] ?? '')) ?></li>
    <?php endforeach; ?>
  </ul>
</div>

<div class="card">
  <h3>Lampiran</h3>
  <p class="muted">Terisi setelah AttachmentRepo diimplementasikan.</p>
  <ul>
    <?php foreach ($atts as $a): ?>
      <li><?= htmlspecialchars($a['filename'] ?? '') ?> – <?= htmlspecialchars($a['created_at'] ?? '') ?></li>
    <?php endforeach; ?>
  </ul>
  <p><a class="btn" href="upload.php?nim=<?= urlencode($student['nim']) ?>">Upload Lampiran</a></p>
</div>
<?php layout_footer(); ?>
