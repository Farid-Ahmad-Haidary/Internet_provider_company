<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
?>
<style>
  /* Topbar with improved gradient */
  .topbar {
    /* teal -> cyan -> indigo smooth gradient with fallback color */
    background: #06b6d4;
    background: linear-gradient(90deg, #0b9488 0%, #0b9488 50%, #6366f1 100%);
    color: white;
    padding: 15px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1); /* slightly lighter shadow */
    font-family: Arial, sans-serif;
    position: sticky;
    top: 0;
    z-index: 1000;
    border-radius: 0 0 12px 12px; /* soft rounded bottom */
  }

  .topbar .brand {
    font-size: 22px;
    font-weight: 700;
    letter-spacing: 1px;
  }

  .topbar nav a {
    color: white;
    text-decoration: none;
    margin-left: 20px;
    font-weight: 600;
    padding: 6px 14px;
    border-radius: 8px;
    transition: 0.2s ease, transform 0.2s ease;
    background: rgba(255, 255, 255, 0.1);
  }

  .topbar nav a:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: translateY(-2px);
  }

  /* Responsive for small screens */
  @media (max-width: 768px) {
    .topbar {
      flex-direction: column;
      align-items: flex-start;
      padding: 12px 20px;
    }
    .topbar nav {
      margin-top: 10px;
      display: flex;
      flex-wrap: wrap;
    }
    .topbar nav a {
      margin-left: 0;
      margin-right: 10px;
      margin-top: 6px;
    }
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
