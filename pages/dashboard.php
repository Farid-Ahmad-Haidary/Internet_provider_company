<?php
include __DIR__ . '/../includes/db.php';

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
</head>

<body style="margin:0; padding:0; background:#f5f7fa; font-family:Arial, sans-serif;">

<?php include 'parts/topbar.php'; ?>

<!-- MAIN CONTAINER -->
<main style="
    min-height: calc(100vh - 120px);
    padding: 30px;
    display: flex;
    flex-direction: column;
    align-items: center;
">

  <h1 style="color:#0b9488; margin-bottom:10px;">Welcome <?= $user['username'] ?></h1>
  <p style="color:#666; margin-bottom:30px;">Role: <?= $user['role'] ?></p>

  <!-- CARDS WRAPPER -->
  <div style="
      display:flex;
      gap:25px;
      flex-wrap:wrap;
      justify-content:center;
      width:100%;
      max-width:1100px;
  ">

    <?php if ($user['role'] === 'admin'): ?>

      <!-- WORKERS CARD -->
      <div style="
          flex:1 1 330px;
          max-width:400px;
          background:white;
          border-radius:12px;
          box-shadow:0 8px 25px rgba(0,0,0,0.08);
          overflow:hidden;
      ">
        <div style="background:#0b9488; color:white; padding:18px; font-size:20px; font-weight:bold;">
          Manage Workers
        </div>
        <div style="padding:20px; color:#444;">
          <p>View, add or edit worker accounts and permissions.</p>
          <a href="index.php?p=admin_workers"
             style="display:inline-block; margin-top:10px; padding:10px 16px;
                    background:#0b9488; color:white; text-decoration:none;
                    border-radius:6px; font-weight:bold;">
             Open Workers
          </a>
        </div>
      </div>

      <!-- CUSTOMERS CARD -->
      <div style="
          flex:1 1 330px;
          max-width:400px;
          background:white;
          border-radius:12px;
          box-shadow:0 8px 25px rgba(0,0,0,0.08);
          overflow:hidden;
      ">
        <div style="background:#0b9488; color:white; padding:18px; font-size:20px; font-weight:bold;">
          Manage Customers
        </div>
        <div style="padding:20px; color:#444;">
          <p>Browse and manage customer accounts and subscriptions.</p>
          <a href="index.php?p=admin_customers"
             style="display:inline-block; margin-top:10px; padding:10px 16px;
                    background:#0b9488; color:white; text-decoration:none;
                    border-radius:6px; font-weight:bold;">
             Open Customers
          </a>
        </div>
      </div>

    <?php elseif ($user['role'] === 'worker'): ?>

      <!-- WORKER CARD -->
      <div style="
          flex:1 1 330px;
          max-width:400px;
          background:white;
          border-radius:12px;
          box-shadow:0 8px 25px rgba(0,0,0,0.08);
          overflow:hidden;
      ">
        <div style="background:#0b9488; color:white; padding:18px; font-size:20px; font-weight:bold;">
          Worker Panel
        </div>
        <div style="padding:20px; color:#444;">
          <a href="index.php?p=worker_profile"
             style="display:inline-block; padding:10px 16px;
                    background:#0b9488; color:white; text-decoration:none;
                    border-radius:6px; font-weight:bold;">
            My Profile
          </a>
        </div>
      </div>

    <?php else: ?>

      <!-- CUSTOMER CARD -->
      <div style="
          flex:1 1 330px;
          max-width:400px;
          background:white;
          border-radius:12px;
          box-shadow:0 8px 25px rgba(0,0,0,0.08);
          overflow:hidden;
      ">
        <div style="background:#0b9488; color:white; padding:18px; font-size:20px; font-weight:bold;">
          Customer Panel
        </div>
        <div style="padding:20px; color:#444;">
          <a href="index.php?p=customer_view"
             style="display:inline-block; padding:10px 16px;
                    background:#0b9488; color:white; text-decoration:none;
                    border-radius:6px; font-weight:bold;">
            My Details
          </a>
        </div>
      </div>

    <?php endif; ?>

  </div>
</main>

<!-- FOOTER -->
<footer style="
    text-align:center;
    padding:20px;
    color:#666;
    background:#f0f0f0;
">
  © 2025 Khawar Bridge Internet Company
</footer>

</body>
</html>
