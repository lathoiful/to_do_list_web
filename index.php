<?php
require 'db.php';

// ambil tasks
$stmt = $pdo->query("SELECT * FROM tasks ORDER BY created_at DESC");
$tasks = $stmt->fetchAll();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>To-Do List</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1>To-Do List</h1>

    <!-- Form tambah -->
    <form action="add.php" method="post" class="add-form">
      <input type="text" name="title" placeholder="Tambah tugas baru..." required>
      <button type="submit">Tambah</button>
    </form>

    <!-- Daftar tugas -->
    <ul class="tasks">
      <?php if (count($tasks) === 0): ?>
        <li class="empty">Belum ada tugas.</li>
      <?php else: ?>
        <?php foreach ($tasks as $task): ?>
          <li>
            <span class="<?= $task['status'] ? 'done' : '' ?>">
              <?= htmlspecialchars($task['title']) ?>
            </span>
            <div class="actions">
              <?php if (!$task['status']): ?>
                <a href="edit.php?id=<?= $task['id'] ?>&action=done" class="btn">Selesai</a>
              <?php else: ?>
                <a href="edit.php?id=<?= $task['id'] ?>&action=undone" class="btn">Batal</a>
              <?php endif; ?>
              <a href="edit.php?id=<?= $task['id'] ?>&action=edit" class="btn">Edit</a>
              <a href="delete.php?id=<?= $task['id'] ?>" class="btn del" onclick="return confirm('Hapus tugas?')">Hapus</a>
            </div>
          </li>
        <?php endforeach; ?>
      <?php endif; ?>
    </ul>
  </div>
</body>
</html>
