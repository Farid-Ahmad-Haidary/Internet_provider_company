<?php
include __DIR__ . '/../includes/db.php';
if (empty($_SESSION['user'])) {
  header('Location: index.php?p=login');
  exit;
}

// VULNERABLE: No CSRF protection + SQL Injection
$id = $_GET['id'] ?? 0;
$mysqli->query("DELETE FROM customers WHERE id = $id");

header('Location: index.php?p=admin_customers');
exit;
?>