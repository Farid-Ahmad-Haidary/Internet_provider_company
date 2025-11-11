<?php include __DIR__ . '/../includes/db.php';
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header('Location: index.php?p=login');
  exit;
}
$res = $mysqli->query('SELECT id,name,activated_package FROM customers ORDER BY id DESC'); ?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Customers</title>
  <link rel="stylesheet" href="assets/styles.css">
</head>

<body><?php include 'parts/topbar.php'; ?><main class="container">
    <h2>Customers</h2>
    <p style="margin:1rem 0;">
      <a href="index.php?p=admin_customer_create"
        style="display:inline-block;padding:0.5rem 0.9rem;background:#2b8aef;color:#fff;text-decoration:none;border-radius:8px;box-shadow:0 6px 18px rgba(43,138,239,0.18);font-weight:600;border:1px solid rgba(0,0,0,0.06);transition:transform .12s ease,box-shadow .12s ease,opacity .12s ease;"
        onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 14px 30px rgba(43,138,239,0.18)';this.style.opacity='0.98';"
        onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 6px 18px rgba(43,138,239,0.18)';this.style.opacity='1';"
        onfocus="this.style.outline='3px solid rgba(43,138,239,0.18)';"
        onblur="this.style.outline='none';">
        + Create Customer
      </a>
    </p>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Package</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody><?php while ($r = $res->fetch_assoc()): ?><tr>
            <td><?= $r['id'] ?></td>
            <td><?= htmlspecialchars($r['name']) ?></td>
            <td><?= htmlspecialchars($r['activated_package']) ?></td>
            <td>
              <a href="index.php?p=admin_customer_edit&id=<?= $r['id'] ?>"
                style="display:inline-block;padding:0.4rem 0.8rem;background:#2b8aef;color:#fff;text-decoration:none;border-radius:6px;margin-right:8px;border:1px solid rgba(0,0,0,0.06);box-shadow:0 6px 14px rgba(43,138,239,0.12);transition:transform .12s ease,box-shadow .12s ease;"
                onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 12px 24px rgba(43,138,239,0.16)';"
                onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 6px 14px rgba(43,138,239,0.12)';"
                onfocus="this.style.outline='3px solid rgba(43,138,239,0.12)';"
                onblur="this.style.outline='none';">
                Edit
              </a>
              <a href="index.php?p=admin_customer_delete&id=<?= $r['id'] ?>"
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
  </main>
  <?php include 'parts/footer.php'; ?>
</body>

</html>