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

  $desired = $mysqli->real_escape_string($name);
  $check = $mysqli->query("SELECT id FROM users WHERE username = '$desired' AND NOT (username = '" . $mysqli->real_escape_string($w['name']) . "') LIMIT 1");
  if ($check && $check->fetch_assoc()) {
    $new_username = $mysqli->real_escape_string($name . '.' . $id);
  } else {
    $new_username = $desired;
  }

  $mysqli->query("UPDATE workers SET name='" . $mysqli->real_escape_string($name) . "', password='" . $mysqli->real_escape_string($password) . "', field='" . $mysqli->real_escape_string($field) . "', salary=" . $salary . " WHERE id=$id");

  $old_name_esc = $mysqli->real_escape_string($w['name']);
  $worker_id_username = 'worker' . $id;
  $mysqli->query("UPDATE users SET username='" . $new_username . "', password='" . $mysqli->real_escape_string($password) . "' WHERE username IN ('" . $mysqli->real_escape_string($worker_id_username) . "', '" . $old_name_esc . "', '" . $old_name_esc . "." . $id . "')");

  if ($mysqli->affected_rows === 0) {
    $ck2 = $mysqli->query("SELECT id FROM users WHERE username = '" . $new_username . "' LIMIT 1");
    if (!($ck2 && $ck2->fetch_assoc())) {
      $mysqli->query("INSERT INTO users (username,password,role) VALUES ('" . $new_username . "','" . $mysqli->real_escape_string($password) . "','worker')");
    }
  }

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
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: sans-serif;
      background: #fff;
    }

    main.container {
      max-width: 700px;
      margin: 40px auto;
      background: #ffffffee;
      padding: 30px;
      border-radius: 14px;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
      animation: fadeIn 0.4s ease-in-out;
    }

    main.container h2 {
      color: #044c47;
      font-size: 24px;
      margin-bottom: 25px;
      text-align: center;
    }

    form {
      display: flex;
      flex-direction: column;
    }

    label {
      font-size: 14px;
      font-weight: bold;
      color: #044c47;
      margin-top: 12px;
    }

    input {
      padding: 10px;
      border-radius: 8px;
      margin-top: 4px;
      border: 2px solid #0b9488;
      outline: none;
      transition: 0.2s;
    }

    input:focus {
      border-color: #044c47;
      box-shadow: 0 0 6px rgba(11, 148, 136, 0.3);
    }

    button {
      margin-top: 20px;
      padding: 12px;
      border: none;
      border-radius: 10px;
      background: linear-gradient(135deg, #0b9488, #044c47);
      color: #fff;
      font-weight: bold;
      font-size: 15px;
      cursor: pointer;
      transition: 0.2s;
    }

    button:hover {
      opacity: 0.9;
      transform: translateY(-2px);
    }

    .success {
      background: #0b9488;
      color: white;
      padding: 12px;
      border-radius: 8px;
      text-align: center;
      margin-bottom: 15px;
      font-weight: bold;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
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
