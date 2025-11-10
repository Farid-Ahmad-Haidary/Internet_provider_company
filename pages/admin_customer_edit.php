<?php include __DIR__ . '/../includes/db.php';
session_start();
if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header('Location: index.php?p=login');
  exit;
}
$id = intval($_GET['id'] ?? 0);
$res = $mysqli->query("SELECT * FROM customers WHERE id=$id LIMIT 1");
$c = $res->fetch_assoc();
if (!$c) exit('Not found');
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'] ?? $c['name'];
  $password = $_POST['password'] ?? $c['password'];
  $pkg = $_POST['activated_package'] ?? $c['activated_package'];
  $mysqli->query("UPDATE customers SET name='" . $name . "', password='" . $password . "', activated_package='" . $pkg . "' WHERE id=$id");
  $mysqli->query("UPDATE users SET username='customer" . $id . "', password='" . $password . "' WHERE username='customer" . $id . "'");
  $msg = 'Saved';
  $res = $mysqli->query("SELECT * FROM customers WHERE id=$id LIMIT 1");
  $c = $res->fetch_assoc();
} ?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Edit Customer</title>
  <link rel="stylesheet" href="assets/styles.css">
</head>

<body><?php include 'parts/topbar.php'; ?><main class="container">
    <h2>Edit Customer</h2><?php if ($msg) echo '<div class="success">' . htmlspecialchars($msg) . '</div>'; ?>
    <form method="post"><label>Name</label><input name="name" value="<?= htmlspecialchars($c['name']) ?>"><label>Password</label><input name="password" value="<?= htmlspecialchars($c['password']) ?>"><label>Activated Package</label><input name="activated_package" value="<?= htmlspecialchars($c['activated_package']) ?>"><button>Save</button></form>
  </main><?php include 'parts/footer.php'; ?></body>

</html>