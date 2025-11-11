<?php include __DIR__ . '/../includes/db.php';
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'worker') {
  header('Location: index.php?p=login');
  exit;
}

$uname = $mysqli->real_escape_string($_SESSION['user']['username']);
$res = $mysqli->query("SELECT * FROM workers WHERE name='" . $uname . "' LIMIT 1");
$w = $res->fetch_assoc();
if (!$w) exit('Profile missing');

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'] ?? $w['name'];
  $password = $_POST['password'] ?? '';
  $field = $_POST['field'] ?? $w['field'];

  if ($password !== '') {
    $mysqli->query("UPDATE workers SET name='" . $mysqli->real_escape_string($name) . "', password='" . $mysqli->real_escape_string($password) . "', field='" . $mysqli->real_escape_string($field) . "' WHERE name='" . $uname . "'");
    // also update users table so login remains consistent
    $mysqli->query("UPDATE users SET username='" . $mysqli->real_escape_string($name) . "', password='" . $mysqli->real_escape_string($password) . "' WHERE username='" . $uname . "'");
    // refresh session username
    $_SESSION['user']['username'] = $name;
  } else {
    $mysqli->query("UPDATE workers SET name='" . $mysqli->real_escape_string($name) . "', field='" . $mysqli->real_escape_string($field) . "' WHERE name='" . $uname . "'");
    $mysqli->query("UPDATE users SET username='" . $mysqli->real_escape_string($name) . "' WHERE username='" . $uname . "'");
    $_SESSION['user']['username'] = $name;
  }
  $msg = 'Saved';
  $res = $mysqli->query("SELECT * FROM workers WHERE name='" . $mysqli->real_escape_string($name) . "' LIMIT 1");
  $w = $res->fetch_assoc();
}
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>My Profile</title>
  <link rel="stylesheet" href="assets/styles.css">
</head>

<body><?php include 'parts/topbar.php'; ?>
  <main class="container">
    <h2>My Worker Profile</h2>
    <?php if ($msg) echo '<div class="success">' . htmlspecialchars($msg) . '</div>'; ?>
    <form method="post">
      <label>Name</label><input name="name" value="<?= htmlspecialchars($w['name']) ?>">
      <label>New Password</label><input name="password" type="text">
      <label>Field</label><input name="field" value="<?= htmlspecialchars($w['field']) ?>">
      <label>Salary (readonly)</label><input name="salary" value="<?= htmlspecialchars($w['salary']) ?>" readonly>
      <button>Save</button>
    </form>
  </main>
  <?php include 'parts/footer.php'; ?>
</body>

</html>