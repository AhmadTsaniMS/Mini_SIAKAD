<?php
require_once __DIR__ . '/../src/Db.php';
require_once __DIR__ . '/../src/StudentRepo.php';
require_once __DIR__ . '/../src/CourseRepo.php';
require_once __DIR__ . '/../src/GradeRepo.php';
require_once __DIR__ . '/../src/Logger.php';
require_once __DIR__ . '/_layout.php';

$pdo = Db::pdo();
$nim = $_GET['nim'] ?? '';
$msg = '';
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nim = $_POST['nim'] ?? '';
  $course = $_POST['course'] ?? '';
  $score = (int)($_POST['score'] ?? 0);

  $st = StudentRepo::findByNim($pdo, $nim);
  $cr = CourseRepo::findByCode($pdo, $course);

  if (!$st || !$cr) {
    $err = "Mahasiswa/MK tidak ditemukan.";
  } else {
    $ok = GradeRepo::add($pdo, (int)$st['id'], (int)$cr['id'], $score);
    if ($ok) {
      Logger::info("Add grade nim={$nim} course={$course} score={$score}");
      $msg = "Nilai berhasil disimpan.";
    } else {
      $err = "Gagal simpan nilai (cek implementasi GradeRepo).";
    }
  }
}

$courses = CourseRepo::list($pdo);

layout_header('Input Nilai');
?>
<div class="card">
  <h2>Input Nilai</h2>
  <?php if ($msg): ?><p style="color:green;"><b><?= htmlspecialchars($msg) ?></b></p><?php endif; ?>
  <?php if ($err): ?><p style="color:red;"><b><?= htmlspecialchars($err) ?></b></p><?php endif; ?>

  <form method="post">
    <div class="row">
      <div class="col">NIM<br><input name="nim" value="<?= htmlspecialchars($nim) ?>" required></div>
      <div class="col">Mata Kuliah<br>
        <select name="course" required>
          <option value="">-- pilih --</option>
          <?php foreach ($courses as $c): ?>
            <option value="<?= htmlspecialchars($c['code'] ?? '') ?>"><?= htmlspecialchars(($c['code'] ?? '') . ' - ' . ($c['name'] ?? '')) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col">Nilai (0-100)<br><input name="score" type="number" min="0" max="100" required></div>
    </div>
    <p><button class="btn" type="submit">Simpan</button></p>
  </form>
</div>
<?php layout_footer(); ?>
