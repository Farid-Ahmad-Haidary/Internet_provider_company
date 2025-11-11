<?php
include __DIR__ . '/../includes/db.php';
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header('Location: index.php?p=login');
  exit;
}

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) exit('Invalid id');

$res = $mysqli->query("SELECT * FROM workers WHERE id = $id LIMIT 1");
$w = $res->fetch_assoc();
if (!$w) exit('Worker not found');

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name'] ?? $w['name']);
  $password = $_POST['password'] ?? $w['password'];
  $field = $_POST['field'] ?? $w['field'];
  $salary = floatval($_POST['salary'] ?? $w['salary']);

  // determine desired username and ensure uniqueness (ignore the current user's own username)
  $desired = $mysqli->real_escape_string($name);
  $check = $mysqli->query("SELECT id FROM users WHERE username = '$desired' AND NOT (username = '" . $mysqli->real_escape_string($w['name']) . "') LIMIT 1");
  if ($check && $check->fetch_assoc()) {
    $new_username = $mysqli->real_escape_string($name . '.' . $id);
  } else {
    $new_username = $desired;
  }

  // Update workers table
  $mysqli->query("UPDATE workers SET name='" . $mysqli->real_escape_string($name) . "', password='" . $mysqli->real_escape_string($password) . "', field='" . $mysqli->real_escape_string($field) . "', salary=" . $salary . " WHERE id=$id");

  // Sync users table:
  // Try to update possible existing linked user records:
  // - username could be 'worker{id}', or old name, or oldname.{id}
  $old_name_esc = $mysqli->real_escape_string($w['name']);
  $worker_id_username = 'worker' . $id;
  // Update any user whose username references this worker to new_username and new password
  $mysqli->query("UPDATE users SET username='" . $new_username . "', password='" . $mysqli->real_escape_string($password) . "' WHERE username IN ('" . $mysqli->real_escape_string($worker_id_username) . "', '" . $old_name_esc . "', '" . $old_name_esc . "." . $id . "')");

  // If no row updated above (rare), try to insert a new users row for this worker
  if ($mysqli->affected_rows === 0) {
    // ensure username not taken now
    $ck2 = $mysqli->query("SELECT id FROM users WHERE username = '" . $new_username . "' LIMIT 1");
    if (!($ck2 && $ck2->fetch_assoc())) {
      $mysqli->query("INSERT INTO users (username,password,role) VALUES ('" . $new_username . "','" . $mysqli->real_escape_string($password) . "','worker')");
    }
  }

  // refresh loaded worker row
  $res = $mysqli->query("SELECT * FROM workers WHERE id = $id LIMIT 1");
  $w = $res->fetch_assoc();
  $msg = 'Saved';
}
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Edit Worker</title>
  <link rel="stylesheet" href="assets/styles.css">
</head>

<body>
  <?php include 'parts/topbar.php'; ?>
  <main class="container">
    <h2>Edit Worker</h2>
    <?php if ($msg) echo '<div class="success">' . htmlspecialchars($msg) . '</div>'; ?>
    <form method="post">
      <label>Name</label>
      <input name="name" value="<?= htmlspecialchars($w['name']) ?>">
      <label>Password</label>
      <input name="password" value="<?= htmlspecialchars($w['password']) ?>">
      <label>Field</label>
      <input name="field" value="<?= htmlspecialchars($w['field']) ?>">
      <label>Salary</label>
      <input name="salary" type="number" step="0.01" value="<?= htmlspecialchars($w['salary']) ?>">
      <button>Save</button>
    </form>
  </main>
  <?php include 'parts/footer.php'; ?>
</body>

</html>