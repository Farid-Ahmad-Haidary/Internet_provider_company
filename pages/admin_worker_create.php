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
  $field = $_POST['field'] ?? '';
  $salary = $_POST['salary'] ?? 0;

  // create worker row
  $mysqli->query("INSERT INTO workers (name,password,field,salary) VALUES ('" . $mysqli->real_escape_string($name) . "','" . $mysqli->real_escape_string($password) . "','" . $mysqli->real_escape_string($field) . "'," . floatval($salary) . ")");
  $wid = $mysqli->insert_id;

  // try to set users.username = name, if taken append .id
  $desired = $mysqli->real_escape_string($name);
  $check = $mysqli->query("SELECT id FROM users WHERE username = '" . $desired . "' LIMIT 1");
  if ($check && $check->fetch_assoc()) {
    $login_username = $mysqli->real_escape_string($name . '.' . $wid);
  } else {
    $login_username = $desired;
  }

  // create login account for worker
  $mysqli->query("INSERT INTO users (username,password,role) VALUES ('" . $login_username . "','" . $mysqli->real_escape_string($password) . "','worker')");
  $msg = 'Created. Login username: ' . htmlspecialchars($login_username);
}
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Create Worker</title>

  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background: #f5fafa;
    }

    /* Header / Back bar */
    .top-bar {
      background: #0b9488;
      color: white;
      padding: 15px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    }

    .top-bar a {
      color: #fff;
      text-decoration: none;
      font-weight: 600;
      font-size: 15px;
    }

    /* Main container */
    .container {
      max-width: 540px;
      margin: 30px auto;
      background: white;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
    }

    h2 {
      color: #0b9488;
      font-size: 26px;
      margin-bottom: 20px;
      font-weight: 700;
      text-align: center;
    }

    label {
      font-weight: 600;
      margin-top: 8px;
      display: block;
      color: #333;
    }

    input {
      width: 100%;
      padding: 10px;
      border-radius: 8px;
      border: 1px solid #ced4da;
      font-size: 15px;
      margin-top: 4px;
      margin-bottom: 14px;
      transition: 0.15s border-color;
    }

    input:focus {
      border-color: #0b9488;
      outline: none;
      box-shadow: 0 0 4px rgba(11, 148, 136, 0.4);
    }

    /* Create Button */
    button {
      width: 100%;
      padding: 12px;
      background: #0b9488;
      border: none;
      border-radius: 8px;
      color: white;
      font-weight: 700;
      font-size: 15px;
      cursor: pointer;
      box-shadow: 0 6px 18px rgba(11, 148, 136, 0.15);
      transition: 0.15s ease;
    }

    button:hover {
      background: #097a70;
      transform: translateY(-2px);
      box-shadow: 0 10px 24px rgba(11, 148, 136, 0.25);
    }

    /* Success message */
    .success {
      background: #d1f3e8;
      padding: 12px;
      border-radius: 8px;
      margin-bottom: 15px;
      color: #055f41;
      font-weight: 600;
      border-left: 4px solid #0b9488;
      box-shadow: 0 4px 12px rgba(11, 148, 136, 0.12);
    }
  </style>
</head>

<body>

  <div class="top-bar">
    <a href="index.php?p=admin_workers">← Back to Workers</a>
  </div>

  <main class="container">

    <h2>Create New Worker</h2>

    <?php if ($msg): ?>
        <div class="success"><?= $msg ?></div>
    <?php endif; ?>

    <form method="post">
      <label>Name:</label>
      <input type="text" name="name" required>

      <label>Password:</label>
      <input type="text" name="password" required>

      <label>Field:</label>
      <input type="text" name="field" required>

      <label>Salary:</label>
      <input type="number" name="salary" step="0.01" required>

      <button type="submit">Create Worker</button>
    </form>

  </main>

</body>
</html>
