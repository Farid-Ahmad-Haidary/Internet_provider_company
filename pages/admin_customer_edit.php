<?php
include __DIR__ . '/../includes/db.php';
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') { header('Location: index.php?p=login'); exit; }

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) exit('Invalid id');

$res = $mysqli->query("SELECT * FROM customers WHERE id = $id LIMIT 1");
$c = $res->fetch_assoc();
if (!$c) exit('Customer not found');

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? $c['name']);
    $password = $_POST['password'] ?? $c['password'];
    $pkg = $_POST['activated_package'] ?? $c['activated_package'];

    // desired username and uniqueness check (ignore current)
    $desired = $mysqli->real_escape_string($name);
    $check = $mysqli->query("SELECT id FROM users WHERE username = '$desired' AND NOT (username = '" . $mysqli->real_escape_string($c['name']) . "') LIMIT 1");
    if ($check && $check->fetch_assoc()) {
        $new_username = $mysqli->real_escape_string($name . '.' . $id);
    } else {
        $new_username = $desired;
    }

    // Update customers table
    $mysqli->query("UPDATE customers SET name='" . $mysqli->real_escape_string($name) . "', password='" . $mysqli->real_escape_string($password) . "', activated_package='" . $mysqli->real_escape_string($pkg) . "' WHERE id=$id");

    // Sync users table: possible old usernames: 'customer{id}', old name, oldname.{id}
    $old_name_esc = $mysqli->real_escape_string($c['name']);
    $customer_id_username = 'customer' . $id;
    $mysqli->query("UPDATE users SET username='" . $new_username . "', password='" . $mysqli->real_escape_string($password) . "' WHERE username IN ('" . $mysqli->real_escape_string($customer_id_username) . "', '" . $old_name_esc . "', '" . $old_name_esc . "." . $id . "')");

    // If nothing updated, insert a users row for this customer
    if ($mysqli->affected_rows === 0) {
        $ck2 = $mysqli->query("SELECT id FROM users WHERE username = '" . $new_username . "' LIMIT 1");
        if (!($ck2 && $ck2->fetch_assoc())) {
            $mysqli->query("INSERT INTO users (username,password,role) VALUES ('" . $new_username . "','" . $mysqli->real_escape_string($password) . "','customer')");
        }
    }

    // refresh
    $res = $mysqli->query("SELECT * FROM customers WHERE id = $id LIMIT 1");
    $c = $res->fetch_assoc();
    $msg = 'Saved';
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Edit Customer</title>
  <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
<?php include 'parts/topbar.php'; ?>
<main class="container">
  <h2>Edit Customer</h2>
  <?php if ($msg) echo '<div class="success">'.htmlspecialchars($msg).'</div>'; ?>
  <form method="post">
    <label>Name</label>
    <input name="name" value="<?= htmlspecialchars($c['name']) ?>">
    <label>Password</label>
    <input name="password" value="<?= htmlspecialchars($c['password']) ?>">
    <label>Activated Package</label>
    <input name="activated_package" value="<?= htmlspecialchars($c['activated_package']) ?>">
    <button>Save</button>
  </form>
</main>
<?php include 'parts/footer.php'; ?>
</body>
</html>
