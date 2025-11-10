<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

// inline style for links (reusable) - smaller size and success color
$linkStyle = 'style="color:#fff;text-decoration:none;padding:4px 8px;border-radius:4px;background:#28a745;margin-right:6px;font-weight:600;display:inline-block;font-size:13px;" onmouseover="this.style.background=\'#218838\';" onmouseout="this.style.background=\'#28a745\';"';
?>
<header class="topbar" style="padding:12px;color:#fff;display:flex;align-items:center;justify-content:space-between;">
  <div class="brand" style="font-weight:700;">Internet ISP - VULN</div>
  <?php if (!empty($_SESSION['user'])): ?>
    <nav>
      <a href="index.php?p=dashboard" <?php echo $linkStyle; ?>>Dashboard</a> |
      <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin'): ?>
        <a href="index.php?p=admin_workers" <?php echo $linkStyle; ?>>Workers</a> |
        <a href="index.php?p=admin_customers" <?php echo $linkStyle; ?>>Customers</a> |
      <?php endif; ?>
      <a href="index.php?p=logout" <?php echo $linkStyle; ?>>Logout</a>
    </nav>
  <?php endif; ?>
</header>