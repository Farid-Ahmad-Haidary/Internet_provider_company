<?php include __DIR__ . '/../includes/db.php';
session_start();
if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header('Location: index.php?p=login');
  exit;
}
$id = intval($_GET['id'] ?? 0);
$mysqli->query("DELETE FROM customers WHERE id=$id");
$mysqli->query("DELETE FROM users WHERE username='customer" . $id . "'");
header('Location: index.php?p=admin_customers');
exit;
