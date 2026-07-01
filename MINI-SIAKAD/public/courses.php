<?php
require_once __DIR__ . '/../src/Db.php';
require_once __DIR__ . '/../src/CourseRepo.php';
require_once __DIR__ . '/_layout.php';

$pdo = Db::pdo();
$courses = CourseRepo::list($pdo);

layout_header('Mata Kuliah');
?>
<div class="card">
  <h2>Mata Kuliah</h2>
  <p class="muted">Tabel ini akan terisi setelah CourseRepo::list() diimplementasikan.</p>
  <table>
    <tr><th>Kode</th><th>Nama</th><th>SKS</th></tr>
    <?php foreach ($courses as $c): ?>
      <tr>
        <td><?= htmlspecialchars($c['code'] ?? '') ?></td>
        <td><?= htmlspecialchars($c['name'] ?? '') ?></td>
        <td><?= (int)($c['sks'] ?? 0) ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>
<?php layout_footer(); ?>
