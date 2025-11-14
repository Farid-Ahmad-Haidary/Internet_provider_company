<?php 
include __DIR__ . '/../includes/db.php';
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'worker') {
  header('Location: index.php?p=login');
  exit;
}

$uname = $_SESSION['user']['username'];
$res = $mysqli->query("SELECT * FROM workers WHERE name='$uname' LIMIT 1");
$w = $res->fetch_assoc();
if (!$w) exit('Profile missing');

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $password = $_POST['password'];
  $field = $_POST['field'];

  if ($password !== '') {
    $mysqli->query("UPDATE workers SET name='$name', password='$password', field='$field' WHERE name='$uname'");
    $mysqli->query("UPDATE users SET username='$name', password='$password' WHERE username='$uname'");
    $_SESSION['user']['username'] = $name;
  } else {
    $mysqli->query("UPDATE workers SET name='$name', field='$field' WHERE name='$uname'");
    $mysqli->query("UPDATE users SET username='$name' WHERE username='$uname'");
    $_SESSION['user']['username'] = $name;
  }

  $msg = "Saved!";
  $res = $mysqli->query("SELECT * FROM workers WHERE name='$name' LIMIT 1");
  $w = $res->fetch_assoc();
}
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>My Profile</title>
  <link rel="stylesheet" href="assets/styles.css">

  <style>
    body {
      background: #f5fafa;
      font-family: Arial, sans-serif;
      margin: 0;
    }

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

<?php include 'parts/topbar.php'; ?>

<main class="container">

  <h2>My Worker Profile</h2>

  <?php if ($msg): ?>
    <div class="success"><?= $msg ?></div>
  <?php endif; ?>

  <form method="post">

    <label>Name</label>
    <input name="name" value="<?= $w['name'] ?>">

    <label>New Password</label>
    <input name="password" type="text">

    <label>Field</label>
    <input name="field" value="<?= $w['field'] ?>">

    <label>Salary (Readonly)</label>
    <input name="salary" value="<?= $w['salary'] ?>" readonly>

    <button>Save</button>

  </form>

</main>

<?php include 'parts/footer.php'; ?>

</body>
</html>
