<?php
require 'db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$action = $_GET['action'] ?? '';

if ($id <= 0) {
    header('Location: index.php'); exit;
}

if ($action === 'done' || $action === 'undone') {
    $new = ($action === 'done') ? 1 : 0;
    $stmt = $pdo->prepare("UPDATE tasks SET status = :s WHERE id = :id");
    $stmt->execute(['s' => $new, 'id' => $id]);
    header('Location: index.php'); exit;
}

if ($action === 'edit') {
    // tampilkan form edit
    $stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $task = $stmt->fetch();
    if (!$task) { header('Location: index.php'); exit; }
    ?>
    <!doctype html>
    <html>
    <head><meta charset="utf-8"><title>Edit tugas</title><link rel="stylesheet" href="style.css"></head>
    <body>
      <div class="container">
        <h1>Edit tugas</h1>
        <form action="edit.php" method="post" class="add-form">
          <input type="hidden" name="id" value="<?= $task['id'] ?>">
          <input type="text" name="title" value="<?= htmlspecialchars($task['title']) ?>" required>
          <button type="submit">Simpan</button>
          <a href="index.php" class="btn">Batal</a>
        </form>
      </div>
    </body>
    </html>
    <?php
    exit;
}

// proses simpan perubahan edit (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    if ($id > 0 && $title !== '') {
        $stmt = $pdo->prepare("UPDATE tasks SET title = :title WHERE id = :id");
        $stmt->execute(['title' => $title, 'id' => $id]);
    }
    header('Location: index.php'); exit;
}
