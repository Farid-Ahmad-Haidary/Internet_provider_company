<?php
include __DIR__ . '/../includes/db.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

if (empty($_SESSION['user'])) {
  header('Location: index.php?p=login');
  exit;
}
$user = $_SESSION['user'];
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Dashboard</title>
  <link rel="stylesheet" href="assets/styles.css">
</head>

<body><?php include 'parts/topbar.php'; ?>
  <main class="container">
    <h1>Welcome <?= htmlspecialchars($user['username']) ?></h1>
    <p class="muted">Role: <?= htmlspecialchars($user['role']) ?></p>

    <div class="cards">
      <?php if ($user['role'] === 'admin'): ?>
        <div class="card">
          <header class="card-header">
            <h3>Manage Workers</h3>
            <span class="badge">Admin</span>
          </header>
          <div class="card-body">
            <p>View, add or edit worker accounts and permissions.</p>
            <p><a class="btn secondary" href="index.php?p=admin_workers">Open Workers</a></p>
          </div>
        </div>

        <div class="card">
          <header class="card-header">
            <h3>Manage Customers</h3>
            <span class="badge">Admin</span>
          </header>
          <div class="card-body">
            <p>Browse and manage customer records, accounts and subscriptions.</p>
            <p><a class="btn secondary" href="index.php?p=admin_customers">Open Customers</a></p>
          </div>
        </div>

      <?php elseif ($user['role'] === 'worker'): ?>
        <div class="card">
          <header class="card-header">
            <h3>Worker</h3>
          </header>
          <div class="card-body">
            <p><a class="btn" href="index.php?p=worker_profile">My Profile</a></p>
          </div>
        </div>
      <?php else: ?>
        <div class="card">
          <header class="card-header">
            <h3>Customer</h3>
          </header>
          <div class="card-body">
            <p><a class="btn" href="index.php?p=customer_view">My Details</a></p>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </main><?php include 'parts/footer.php'; ?>
</body>

</html>