<?php include __DIR__ . '/../includes/db.php'; ?>
<!doctype html><html><head><meta charset="utf-8"><title>Login</title><link rel="stylesheet" href="assets/styles.css"></head><body class="center">
<div class="card"><h2>Internet ISP - VULN Login</h2>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = $_POST['username'] ?? '';
    $p = $_POST['password'] ?? '';
    // vulnerable SQL (no prepared statements)
    $sql = "SELECT id, username, password, role FROM users WHERE username = '$u' LIMIT 1";
    $res = $mysqli->query($sql);
    if ($res && $row = $res->fetch_assoc()) {
        if ($p === $row['password']) {
            $_SESSION['user'] = $row;
            header('Location: index.php?p=dashboard'); exit;
        } else { $err = 'Wrong credentials'; }
    } else { $err = 'Wrong credentials'; }
}
if (!empty($err)) echo '<div class="error">'.htmlspecialchars($err).'</div>';
?>
<form method="post" autocomplete="off">
<label>Username</label><input name="username">
<label>Password</label><input name="password" type="password">
<button>Login</button>
</form>
<p>For setup run <a href="index.php?p=setup">index.php?p=setup</a></p>
</div></body></html>