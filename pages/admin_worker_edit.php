<?php include __DIR__ . '/../includes/db.php';
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header('Location: index.php?p=login');
  exit;
}
$id = intval($_GET['id'] ?? 0);
$res = $mysqli->query("SELECT * FROM workers WHERE id=$id LIMIT 1");
$w = $res->fetch_assoc();
if (!$w) exit('Not found');
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'] ?? $w['name'];
  $password = $_POST['password'] ?? $w['password'];
  $field = $_POST['field'] ?? $w['field'];
  $salary = $_POST['salary'] ?? $w['salary'];
  $mysqli->query("UPDATE workers SET name='" . $name . "', password='" . $password . "', field='" . $field . "', salary=" . $salary . " WHERE id=$id");
  $msg = 'Saved';
  $res = $mysqli->query("SELECT * FROM workers WHERE id=$id LIMIT 1");
  $w = $res->fetch_assoc();
} ?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Edit Worker</title>
  <link rel="stylesheet" href="assets/styles.css">
</head>

<body><?php include 'parts/topbar.php'; ?><main class="container">
    <h2>Edit Worker</h2><?php if ($msg) echo '<div class="success">' . htmlspecialchars($msg) . '</div>'; ?>
    <form method="post"><label>Name</label><input name="name" value="<?= htmlspecialchars($w['name']) ?>"><label>Password</label><input name="password" value="<?= htmlspecialchars($w['password']) ?>"><label>Field</label><input name="field" value="<?= htmlspecialchars($w['field']) ?>"><label>Salary</label><input name="salary" type="number" step="0.01" value="<?= htmlspecialchars($w['salary']) ?>"><button>Save</button></form>
  </main><?php include 'parts/footer.php'; ?></body>

</html>