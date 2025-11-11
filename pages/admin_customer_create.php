<?php include __DIR__ . '/../includes/db.php';
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header('Location: index.php?p=login');
  exit;
}
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'] ?? '';
  $password = $_POST['password'] ?? '';
  $pkg = $_POST['activated_package'] ?? '';
  $mysqli->query("INSERT INTO customers (name,password,activated_package) VALUES ('" . $name . "','" . $password . "','" . $pkg . "')");
  $cid = $mysqli->insert_id;
  $mysqli->query("INSERT INTO users (username,password,role) VALUES ('customer" . $cid . "','" . $password . "','customer')");
  $msg = 'Created. username: customer' . $cid;
} ?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Create Customer</title>
  <link rel="stylesheet" href="assets/styles.css">
</head>

<body><?php include 'parts/topbar.php'; ?><main class="container">
    <h2>Create Customer</h2><?php if ($msg) echo '<div class="success">' . htmlspecialchars($msg) . '</div>'; ?>
    <form method="post"><label>Name</label><input name="name"><label>Password</label><input name="password"><label>Activated Package</label><input name="activated_package"><button>Create</button></form>
  </main><?php include 'parts/footer.php'; ?></body>

</html>