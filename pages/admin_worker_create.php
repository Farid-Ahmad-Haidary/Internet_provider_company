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
  $field = $_POST['field'] ?? '';
  $salary = $_POST['salary'] ?? 0;
  $mysqli->query("INSERT INTO workers (name,password,field,salary) VALUES ('" . $name . "','" . $password . "','" . $field . "'," . $salary . ")");
  $wid = $mysqli->insert_id; // create login user using worker id as username
  $mysqli->query("INSERT INTO users (username,password,role) VALUES ('worker" . $wid . "','" . $password . "','worker')");
  $msg = 'Created. worker username: worker' . $wid;
} ?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Create Worker</title>
  <link rel="stylesheet" href="assets/styles.css">
</head>

<body><?php include 'parts/topbar.php'; ?><main class="container">
    <h2>Create Worker</h2><?php if ($msg) echo '<div class="success">' . htmlspecialchars($msg) . '</div>'; ?>
    <form method="post"><label>Name</label><input name="name"><label>Password</label><input name="password"><label>Field</label><input name="field"><label>Salary</label><input name="salary" type="number" step="0.01"><button>Create</button></form>
  </main><?php include 'parts/footer.php'; ?></body>

</html>