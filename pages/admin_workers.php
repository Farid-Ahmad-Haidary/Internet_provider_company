<?php include __DIR__ . '/../includes/db.php';
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header('Location: index.php?p=login');
  exit;
}
$res = $mysqli->query('SELECT id,name,field,salary FROM workers ORDER BY id DESC');
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Workers</title>
  <link rel="stylesheet" href="assets/styles.css">
</head>

<body><?php include 'parts/topbar.php'; ?><main class="container">
    <h2>Workers</h2>
    <style>
      /* Local styles for the Create Worker button - scoped to this page */
      .create-worker-wrap { margin: 1rem 0; }
      .create-worker-btn {
      display: inline-flex;
      align-items: center;
      gap: .5rem;
      background: linear-gradient(90deg,#2d9cdb,#2a7edb);
      color: #fff;
      padding: .5rem .9rem;
      border-radius: 6px;
      text-decoration: none;
      font-weight: 600;
      box-shadow: 0 2px 6px rgba(43,68,128,0.18);
      transition: transform .12s ease, box-shadow .12s ease, opacity .12s;
      }
      .create-worker-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(43,68,128,0.18); opacity: .98; }
      .create-worker-btn:active { transform: translateY(0); }
      .create-worker-btn .plus { font-size: 1.1rem; line-height: 1; }
    </style>
    <p class="create-worker-wrap">
      <a class="create-worker-btn" href="index.php?p=admin_worker_create" title="Create a new worker">
      <span class="plus">＋</span> Create Worker
      </a>
    </p>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Field</th>
          <th>Salary</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody><?php while ($r = $res->fetch_assoc()): ?><tr>
            <td><?= $r['id'] ?></td>
            <td><?= htmlspecialchars($r['name']) ?></td>
            <td><?= htmlspecialchars($r['field']) ?></td>
            <td><?= htmlspecialchars($r['salary']) ?></td>
            <td>
              <a href="index.php?p=admin_worker_edit&id=<?= $r['id'] ?>"
                style="display:inline-block;padding:0.4rem 0.8rem;background:#2b8aef;color:#fff;text-decoration:none;border-radius:6px;margin-right:8px;border:1px solid rgba(0,0,0,0.06);box-shadow:0 6px 14px rgba(43,138,239,0.12);transition:transform .12s ease,box-shadow .12s ease;"
                onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 12px 24px rgba(43,138,239,0.16)';"
                onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 6px 14px rgba(43,138,239,0.12)';"
                onfocus="this.style.outline='3px solid rgba(43,138,239,0.12)';"
                onblur="this.style.outline='none';">
                Edit
              </a>
              <a href="index.php?p=admin_worker_delete&id=<?= $r['id'] ?>"
                style="display:inline-block;padding:0.4rem 0.8rem;background:#e74c3c;color:#fff;text-decoration:none;border-radius:6px;border:1px solid rgba(0,0,0,0.06);box-shadow:0 6px 14px rgba(231,76,60,0.12);transition:transform .12s ease,box-shadow .12s ease;"
                onclick="return confirm('Delete?')"
                onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 12px 24px rgba(231,76,60,0.16)';"
                onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 6px 14px rgba(231,76,60,0.12)';"
                onfocus="this.style.outline='3px solid rgba(231,76,60,0.12)';"
                onblur="this.style.outline='none';">
                Delete
              </a>
            </td>
          </tr><?php endwhile; ?></tbody>
    </table>
  </main><?php include 'parts/footer.php'; ?></body>

</html>