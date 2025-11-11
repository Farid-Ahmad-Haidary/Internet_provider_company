<?php include __DIR__ . '/../includes/db.php';
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header('Location: index.php?p=login');
  exit;
}
$res = $mysqli->query('SELECT id,name,password,field,salary FROM workers ORDER BY id DESC');
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Workers</title>
  <link rel="stylesheet" href="assets/styles.css">
</head>

<body><?php include 'parts/topbar.php'; ?>
  <main class="container">
    <h2>Workers</h2>
    <style>
      .create-worker-btn {
        display: inline-block;
        padding: 0.55rem 0.9rem;
        background: #0d6efd;
        color: #fff;
        text-decoration: none;
        border-radius: 6px;
        font-weight: 600;
        box-shadow: 0 6px 18px rgba(13,110,253,0.12);
        transition: transform .12s ease, box-shadow .12s ease, background .12s;
        border: 1px solid rgba(255,255,255,0.12);
      }
      .create-worker-btn:hover {
        background: #0b5ed7;
        transform: translateY(-2px);
        box-shadow: 0 10px 22px rgba(11,94,215,0.14);
      }
      .create-worker-btn:active {
        transform: translateY(0);
        box-shadow: 0 6px 12px rgba(11,94,215,0.12);
      }
    </style>
    <p><a class="create-worker-btn" href="index.php?p=admin_worker_create" role="button">Create Worker</a></p>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Password</th>
          <th>Field</th>
          <th>Salary</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($r = $res->fetch_assoc()): ?>
          <tr>
            <td><?= $r['id'] ?></td>
            <td><?= htmlspecialchars($r['name']) ?></td>
            <td><?= htmlspecialchars($r['password']) ?></td>
            <td><?= htmlspecialchars($r['field']) ?></td>
            <td><?= htmlspecialchars($r['salary']) ?></td>
            <td>
              <a href="index.php?p=admin_worker_edit&id=<?= $r['id'] ?>" role="button" style="display:inline-block;padding:.35rem .7rem;background:#0d6efd;color:#fff;text-decoration:none;border-radius:6px;font-weight:600;margin-right:.5rem;box-shadow:0 6px 12px rgba(13,110,253,0.12);">✏️ Edit</a>
              <a href="index.php?p=admin_worker_delete&id=<?= $r['id'] ?>" onclick="return confirm('Are you sure you want to delete this worker?')" role="button" style="display:inline-block;padding:.35rem .7rem;background:#dc3545;color:#fff;text-decoration:none;border-radius:6px;font-weight:600;box-shadow:0 6px 12px rgba(220,53,69,0.12);">🗑️ Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </main>
  <?php include 'parts/footer.php'; ?>
</body>

</html>