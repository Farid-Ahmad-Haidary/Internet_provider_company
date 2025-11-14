<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
?>
<style>
  .topbar {
    background: #333;
    color: white;
    padding: 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .topbar nav a {
    color: white;
    text-decoration: none;
    margin-left: 1rem;
  }
</style>

<header class="topbar">
  <div class="brand">KHAWAR BRIDGE</div>
  <?php if (!empty($_SESSION['user'])): ?>
    <nav>
      <a href="index.php?p=dashboard">Dashboard</a>
      <?php if ($_SESSION['user']['role'] === 'admin'): ?>
        <a href="index.php?p=admin_workers">Workers</a>
        <a href="index.php?p=admin_customers">Customers</a>
      <?php endif; ?>
      <a href="index.php?p=logout">Logout</a>
    </nav>
  <?php endif; ?>
</header>