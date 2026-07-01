<?php
// public/_layout.php – layout sederhana
function layout_header(string $title): void { ?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($title) ?></title>
  <style>
    body{font-family:Arial, sans-serif; margin:0; background:#f6f7fb;}
    .top{background:#1f4e79; color:#fff; padding:14px 18px; font-size:20px; font-weight:700;}
    .wrap{display:flex;}
    .side{width:220px; background:#f0f2f6; min-height:calc(100vh - 52px); padding:14px;}
    .side a{display:block; padding:8px 10px; color:#333; text-decoration:none; border-radius:8px; margin-bottom:4px;}
    .side a:hover{background:#e1e6ef;}
    .main{flex:1; padding:18px;}
    .card{background:#fff; border:1px solid #e0e0e0; border-radius:14px; padding:16px; margin-bottom:14px;}
    table{border-collapse:collapse; width:100%;}
    th,td{border:1px solid #ddd; padding:8px;}
    th{background:#fafafa; text-align:left;}
    .btn{display:inline-block; padding:8px 12px; background:#1f4e79; color:#fff; text-decoration:none; border-radius:10px;}
    .btn:hover{opacity:.9;}
    .muted{color:#666;}
    .row{display:flex; gap:12px; flex-wrap:wrap;}
    .col{flex:1; min-width:260px;}
    input,textarea,select{padding:8px; width:100%; box-sizing:border-box;}
  </style>
</head>
<body>
<div class="top">Mini SIAKAD Lite</div>
<div class="wrap">
  <div class="side">
    <a href="index.php">Dashboard</a>
    <a href="students.php">Mahasiswa</a>
    <a href="courses.php">Mata Kuliah</a>
    <a href="grade_form.php">Input Nilai</a>
    <a href="upload.php">Upload Lampiran</a>
  </div>
  <div class="main">
<?php }

function layout_footer(): void { ?>
  <p class="muted"><small>Template PBL – mahasiswa melengkapi TODO di folder src/.</small></p>
  </div>
</div>
</body>
</html>
<?php } ?>
