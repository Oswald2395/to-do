<?php
// Simple password protection — change this!
define('ADMIN_PASSWORD', 'artist2024');
session_start();

if (isset($_POST['password'])) {
  if ($_POST['password'] === ADMIN_PASSWORD) {
    $_SESSION['admin'] = true;
  } else {
    $error = 'Wrong password.';
  }
}
if (isset($_GET['logout'])) { session_destroy(); header('Location: upload.php'); exit; }

// Handle upload
$msg = '';
if (isset($_SESSION['admin']) && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['works'])) {
  $category  = in_array($_POST['category'] ?? '', ['2d','3d']) ? $_POST['category'] : '2d';
  $uploadDir = __DIR__ . '/../uploads/' . $category . '/';
  $allowed   = ['jpg','jpeg','png','gif','webp','mp4','webm','mov'];
  $uploaded  = 0; $errors = [];

  foreach ($_FILES['works']['name'] as $i => $name) {
    if ($_FILES['works']['error'][$i] !== UPLOAD_ERR_OK) { $errors[] = "$name: upload error."; continue; }
    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) { $errors[] = "$name: type not allowed."; continue; }
    if ($_FILES['works']['size'][$i] > 200 * 1024 * 1024) { $errors[] = "$name: too large (max 200MB)."; continue; }
    $safeName  = preg_replace('/[^a-zA-Z0-9_\-.]/', '_', $name);
    $dest      = $uploadDir . time() . '_' . $safeName;
    if (move_uploaded_file($_FILES['works']['tmp_name'][$i], $dest)) { $uploaded++; }
    else { $errors[] = "$name: failed to move."; }
  }
  $msg = $uploaded . ' file(s) uploaded.';
  if ($errors) $msg .= ' Errors: ' . implode(', ', $errors);
}

// Handle delete
if (isset($_SESSION['admin']) && isset($_GET['delete'])) {
  $cat  = in_array($_GET['cat'] ?? '', ['2d','3d']) ? $_GET['cat'] : '2d';
  $file = basename($_GET['delete']);
  $path = __DIR__ . '/../uploads/' . $cat . '/' . $file;
  if (file_exists($path)) { unlink($path); $msg = 'File deleted.'; }
  header('Location: upload.php'); exit;
}

function listFiles($cat) {
  $dir  = __DIR__ . '/../uploads/' . $cat . '/';
  $exts = ['jpg','jpeg','png','gif','webp','mp4','webm','mov'];
  $out  = [];
  foreach (glob($dir . '*') as $f) {
    if (in_array(strtolower(pathinfo($f, PATHINFO_EXTENSION)), $exts))
      $out[] = ['name'=>basename($f), 'size'=>round(filesize($f)/1024)];
  }
  return $out;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Admin — Upload Works</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;800&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{--bg:#0a0908;--surface:#161410;--border:rgba(255,255,255,0.08);--text:#f0ebe3;--muted:#8a8070;--accent:#c9a96e;--danger:#e07070;--success:#7ec88a}
body{background:var(--bg);color:var(--text);font-family:'Syne',sans-serif;min-height:100vh;padding:2rem}
.wrap{max-width:900px;margin:auto}
.logo{font-size:1.3rem;letter-spacing:.2em;color:var(--accent);margin-bottom:2rem;display:block}
h1{font-size:1.8rem;font-weight:800;margin-bottom:.25rem}
.sub{color:var(--muted);font-size:.9rem;margin-bottom:2.5rem}
.card{background:var(--surface);border:1px solid var(--border);border-radius:12px;padding:2rem;margin-bottom:1.5rem}
.card h2{font-size:1.1rem;margin-bottom:1.5rem;color:var(--accent)}
label{display:block;font-size:.7rem;font-weight:600;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);margin-bottom:.4rem}
input,select{width:100%;background:var(--bg);border:1px solid var(--border);border-radius:6px;padding:.75rem 1rem;color:var(--text);font-family:inherit;font-size:.9rem;outline:none;transition:border-color .2s}
input:focus,select:focus{border-color:var(--accent)}
input[type=file]{cursor:pointer}
.drop-area{border:2px dashed var(--border);border-radius:12px;padding:3rem 2rem;text-align:center;transition:border-color .2s;margin-bottom:1rem}
.drop-area:hover,.drop-area.drag{border-color:var(--accent);background:rgba(201,169,110,.04)}
.drop-icon{font-size:2.5rem;margin-bottom:.75rem}
.drop-text{color:var(--muted);font-size:.9rem;margin-bottom:.75rem}
.row{display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem}
.btn{display:inline-flex;align-items:center;gap:.4rem;padding:.75rem 1.8rem;font-family:inherit;font-size:.78rem;font-weight:600;letter-spacing:.1em;text-transform:uppercase;border-radius:6px;border:none;cursor:pointer;transition:all .2s}
.btn-primary{background:var(--accent);color:#0a0908}
.btn-primary:hover{background:#d4b882}
.btn-danger{background:transparent;border:1px solid var(--danger);color:var(--danger);padding:.35rem .8rem;font-size:.7rem}
.btn-danger:hover{background:rgba(224,112,112,.1)}
.msg{padding:.85rem 1.2rem;border-radius:8px;margin-bottom:1.5rem;font-size:.88rem;background:rgba(126,200,138,.1);border:1px solid rgba(126,200,138,.25);color:var(--success)}
.file-list{display:flex;flex-direction:column;gap:.5rem}
.file-row{display:flex;align-items:center;justify-content:space-between;padding:.6rem .9rem;background:var(--bg);border-radius:6px;border:1px solid var(--border)}
.file-name{font-size:.85rem;word-break:break-all}
.file-size{font-size:.72rem;color:var(--muted);margin-right:1rem;white-space:nowrap}
.empty{color:var(--muted);font-size:.88rem;text-align:center;padding:2rem}
.login-form{max-width:360px;margin:auto;padding-top:20vh}
.login-form h1{text-align:center;margin-bottom:.5rem}
.login-form .sub{text-align:center;margin-bottom:2rem}
.login-form .card{padding:2.5rem}
.nav-bar{display:flex;justify-content:space-between;align-items:center;margin-bottom:3rem}
.logout{font-size:.75rem;color:var(--muted);letter-spacing:.1em;text-transform:uppercase;text-decoration:none;transition:color .2s}
.logout:hover{color:var(--danger)}
a{color:var(--accent)}
.tabs{display:flex;gap:.5rem;margin-bottom:1.5rem}
.tab{padding:.45rem 1.2rem;border:1px solid var(--border);border-radius:100px;font-size:.72rem;font-weight:600;text-transform:uppercase;letter-spacing:.1em;color:var(--muted);cursor:pointer;transition:all .2s}
.tab.active,.tab:hover{border-color:var(--accent);color:var(--accent);background:rgba(201,169,110,.08)}
.tab-panel{display:none}.tab-panel.active{display:block}
@media(max-width:600px){.row{grid-template-columns:1fr}}
</style>
</head>
<body>
<?php if (!isset($_SESSION['admin'])): ?>
  <div class="login-form">
    <h1>Admin</h1>
    <p class="sub">Upload and manage your portfolio</p>
    <div class="card">
      <?php if (!empty($error)): ?><div class="msg" style="background:rgba(224,112,112,.1);border-color:rgba(224,112,112,.25);color:var(--danger)"><?= htmlspecialchars($error) ?></div><?php endif; ?>
      <form method="POST">
        <div style="margin-bottom:1.2rem">
          <label for="password">Password</label>
          <input type="password" name="password" id="password" placeholder="Enter admin password" required autofocus />
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">Enter →</button>
      </form>
    </div>
    <p style="text-align:center;margin-top:1.5rem"><a href="../index.php">← Back to portfolio</a></p>
  </div>
<?php else: ?>
  <div class="wrap">
    <div class="nav-bar">
      <span class="logo">ARTISTÉ — Admin</span>
      <div style="display:flex;gap:1.5rem;align-items:center">
        <a href="../index.php">View Site →</a>
        <a href="?logout=1" class="logout">Logout</a>
      </div>
    </div>

    <?php if ($msg): ?><div class="msg"><?= htmlspecialchars($msg) ?></div><?php endif; ?>

    <!-- UPLOAD CARD -->
    <div class="card">
      <h2>📤 Upload New Works</h2>
      <form method="POST" enctype="multipart/form-data" id="uploadForm">
        <div class="row">
          <div>
            <label for="category">Category</label>
            <select name="category" id="category">
              <option value="2d">2D — Illustration / Drawing / Digital</option>
              <option value="3d">3D — Modeling / Render / Animation</option>
            </select>
          </div>
        </div>
        <div class="drop-area" id="dropArea">
          <div class="drop-icon">🖼️</div>
          <p class="drop-text">Drag & drop files here, or click to browse</p>
          <input type="file" name="works[]" id="fileInput" multiple accept="image/*,video/mp4,video/webm,video/quicktime" style="display:none" />
          <button type="button" class="btn btn-primary" onclick="document.getElementById('fileInput').click()">Browse Files</button>
        </div>
        <div id="filePreview" style="margin-bottom:1rem;display:flex;flex-wrap:wrap;gap:.5rem"></div>
        <p style="font-size:.75rem;color:var(--muted);margin-bottom:1.5rem">Accepted: JPG, PNG, GIF, WEBP, MP4, WEBM, MOV — Max 200MB per file</p>
        <button type="submit" class="btn btn-primary">Upload Files →</button>
      </form>
    </div>

    <!-- FILES LIST -->
    <div class="card">
      <h2>🗂️ Manage Works</h2>
      <div class="tabs">
        <div class="tab active" onclick="switchTab('2d',this)">2D Works</div>
        <div class="tab" onclick="switchTab('3d',this)">3D Works</div>
      </div>

      <?php foreach(['2d','3d'] as $cat): ?>
        <div class="tab-panel <?= $cat==='2d'?'active':'' ?>" id="tab-<?= $cat ?>">
          <?php $files = listFiles($cat); ?>
          <?php if (empty($files)): ?>
            <p class="empty">No files uploaded yet in this category.</p>
          <?php else: ?>
            <div class="file-list">
              <?php foreach($files as $f): ?>
                <div class="file-row">
                  <span class="file-name"><?= htmlspecialchars($f['name']) ?></span>
                  <div style="display:flex;align-items:center;gap:.5rem;flex-shrink:0">
                    <span class="file-size"><?= $f['size'] ?> KB</span>
                    <a href="?delete=<?= urlencode($f['name']) ?>&cat=<?= $cat ?>"
                       class="btn btn-danger"
                       onclick="return confirm('Delete this file?')">Delete</a>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>

  </div>
<?php endif; ?>

<script>
// Drag & drop
const dropArea = document.getElementById('dropArea');
const fileInput = document.getElementById('fileInput');
const preview  = document.getElementById('filePreview');
if (dropArea) {
  ['dragenter','dragover'].forEach(e=>dropArea.addEventListener(e,ev=>{ev.preventDefault();dropArea.classList.add('drag')}));
  ['dragleave','drop'].forEach(e=>dropArea.addEventListener(e,ev=>{ev.preventDefault();dropArea.classList.remove('drag')}));
  dropArea.addEventListener('drop',ev=>{fileInput.files=ev.dataTransfer.files;showPreview(ev.dataTransfer.files)});
  fileInput.addEventListener('change',()=>showPreview(fileInput.files));
}
function showPreview(files){
  preview.innerHTML='';
  [...files].forEach(f=>{
    const tag=document.createElement('span');
    tag.style.cssText='display:inline-flex;align-items:center;gap:.3rem;background:#1a1814;border:1px solid rgba(255,255,255,0.08);padding:.3rem .75rem;border-radius:100px;font-size:.75rem;color:#8a8070';
    tag.textContent=f.name;
    preview.appendChild(tag);
  });
}
// Tabs
function switchTab(cat,el){
  document.querySelectorAll('.tab').forEach(t=>t.classList.remove('active'));
  document.querySelectorAll('.tab-panel').forEach(p=>p.classList.remove('active'));
  el.classList.add('active');
  document.getElementById('tab-'+cat).classList.add('active');
}
</script>
</body>
</html>
