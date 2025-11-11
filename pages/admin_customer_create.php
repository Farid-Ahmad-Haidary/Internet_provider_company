<?php
include __DIR__ . '/../includes/db.php';
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header('Location: index.php?p=login');
  exit;
}

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'] ?? '';
  $password = $_POST['password'] ?? '';
  $pkg = $_POST['activated_package'] ?? '';

  $mysqli->query("INSERT INTO customers (name,password,activated_package) VALUES ('" . $mysqli->real_escape_string($name) . "','" . $mysqli->real_escape_string($password) . "','" . $mysqli->real_escape_string($pkg) . "')");
  $cid = $mysqli->insert_id;

  $desired = $mysqli->real_escape_string($name);
  $check = $mysqli->query("SELECT id FROM users WHERE username = '" . $desired . "' LIMIT 1");
  if ($check && $check->fetch_assoc()) {
    $login_username = $mysqli->real_escape_string($name . '.' . $cid);
  } else {
    $login_username = $desired;
  }

  $mysqli->query("INSERT INTO users (username,password,role) VALUES ('" . $login_username . "','" . $mysqli->real_escape_string($password) . "','customer')");
  $msg = 'Created. login username: ' . htmlspecialchars($login_username);
}
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Create Customer</title>
  <link rel="stylesheet" href="assets/styles.css">
</head>

<body>
  <?php include 'parts/topbar.php'; ?>
  <main class="container">
    <h2>Create Customer</h2>
    <?php if ($msg) echo '<div class="success">' . htmlspecialchars($msg) . '</div>'; ?>
    <form method="post">
      <label>Name</label><input name="name">
      <label>Password</label><input name="password">
      <label>Activated Package</label><input name="activated_package">
      <button>Create</button>
    </form>
  </main>
  <?php include 'parts/footer.php'; ?>
</body>

</html>