<?php include __DIR__ . '/../includes/db.php';
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header('Location: index.php?p=login');
  exit;
}
$res = $mysqli->query('SELECT id,name,password,activated_package FROM customers ORDER BY id DESC');
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Customers</title>
  <link rel="stylesheet" href="assets/styles.css">
</head>

<body><?php include 'parts/topbar.php'; ?>
  <main class="container">
    <h2>Customers</h2>
    <style>
      .create-customer-btn {
      display: inline-block;
      padding: 0.5rem 0.9rem;
      background: linear-gradient(180deg, #0b74de 0%, #006bbf 100%);
      color: #ffffff;
      text-decoration: none;
      border-radius: 6px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.15);
      font-weight: 600;
      border: 1px solid rgba(255,255,255,0.12);
      transition: transform 120ms ease, box-shadow 120ms ease, opacity 120ms;
      }
      .create-customer-btn:hover,
      .create-customer-btn:focus {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.18);
      opacity: 0.98;
      outline: none;
      }
      .create-customer-btn:active {
      transform: translateY(0);
      }
    </style>
    <p><a class="create-customer-btn" href="index.php?p=admin_customer_create" role="button">Create Customer</a></p>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Password</th>
          <th>Package</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($r = $res->fetch_assoc()): ?>
          <tr>
            <td><?= $r['id'] ?></td>
            <td><?= htmlspecialchars($r['name']) ?></td>
            <td><?= htmlspecialchars($r['password']) ?></td>
            <td><?= htmlspecialchars($r['activated_package']) ?></td>
            <td>
                <div class="action-btns">
                <a href="index.php?p=admin_customer_edit&id=<?= $r['id'] ?>" role="button" style="display:inline-block;padding:.35rem .7rem;background:#0d6efd;color:#fff;text-decoration:none;border-radius:6px;font-weight:600;margin-right:.5rem;box-shadow:0 6px 12px rgba(13,110,253,0.12);" title="Edit">✏️ Edit</a>
                <a href="index.php?p=admin_customer_delete&id=<?= $r['id'] ?>" onclick="return confirm('Delete?')" role="button" style="display:inline-block;padding:.35rem .7rem;background:#dc3545;color:#fff;text-decoration:none;border-radius:6px;font-weight:600;box-shadow:0 6px 12px rgba(220,53,69,0.12);" title="Delete">🗑️ Delete</a>
                </div>
              <style>
                .action-btns { display: flex; gap: 0.5rem; align-items: center; }
                .action-btns .btn {
                  display: inline-block;
                  padding: 0.36rem 0.7rem;
                  border-radius: 6px;
                  text-decoration: none;
                  font-weight: 600;
                  font-size: 0.95rem;
                  line-height: 1;
                  border: 1px solid rgba(0,0,0,0.08);
                  box-shadow: 0 2px 6px rgba(0,0,0,0.08);
                  transition: transform 120ms ease, box-shadow 120ms ease, opacity 120ms;
                  color: #fff;
                }
                .action-btns .btn.edit {
                  background: linear-gradient(180deg, #10b981 0%, #059669 100%);
                  border-color: rgba(255,255,255,0.12);
                }
                .action-btns .btn.delete {
                  background: linear-gradient(180deg, #f97316 0%, #ef4444 100%);
                  border-color: rgba(255,255,255,0.12);
                }
                .action-btns .btn:hover,
                .action-btns .btn:focus {
                  transform: translateY(-2px);
                  box-shadow: 0 8px 20px rgba(0,0,0,0.12);
                  opacity: 0.98;
                  outline: none;
                }
                .action-btns .btn:active { transform: translateY(0); }
              </style>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </main>
  <?php include 'parts/footer.php'; ?>
</body>

</html>