<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

// Reusable link style (now cleaner and modern)
$linkStyle = 'class="nav-link"';
?>
<style>
  /* ===== Brand Logo/Text ===== */
  .topbar .brand {
    font-size: 20px;
    font-weight: 700;
    letter-spacing: 1px;
  }

  /* ===== Navigation ===== */
  .topbar nav {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .topbar .nav-link {
    color: #ffffff;
    background-color: #1187d5ed; /* clean blue */
    padding: 6px 14px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: background-color 0.2s ease, transform 0.1s ease;
  }

  .topbar .nav-link:hover {
    background-color: #18378c36; /* darker blue */
    transform: translateY(-1px);
  }

  /* Separator (optional |) */
  .topbar nav span {
    color: #aaa;
    user-select: none;
  }

  /* ===== Responsive ===== */
  @media (max-width: 600px) {
    .topbar {
      flex-direction: column;
      align-items: flex-start;
      gap: 8px;
    }

    .topbar nav {
      flex-wrap: wrap;
      gap: 6px;
    }
  }
</style>

<header class="topbar">
  <div class="brand">KHAWAR BRIDGE</div>
  <?php if (!empty($_SESSION['user'])): ?>
    <nav>
      <a href="index.php?p=dashboard" <?php echo $linkStyle; ?>>Dashboard</a>
      <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin'): ?>
        <a href="index.php?p=admin_workers" <?php echo $linkStyle; ?>>Workers</a>
        <a href="index.php?p=admin_customers" <?php echo $linkStyle; ?>>Customers</a>
      <?php endif; ?>
      <a href="index.php?p=logout" <?php echo $linkStyle; ?>>Logout</a>
    </nav>
  <?php endif; ?>
</header>
