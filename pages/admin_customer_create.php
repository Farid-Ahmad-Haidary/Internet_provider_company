<?php
include __DIR__ . '/../includes/db.php';
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (empty($_SESSION['user'])) {
  header('Location: index.php?p=login');
  exit;
}

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $password = $_POST['password'] ?? '';
    $package = $_POST['package'] ?? '';
    
    // VULNERABLE INSERT - SQL Injection (intentionally vulnerable)
    $sql = "INSERT INTO customers (name, password, activated_package) VALUES ('$name', '$password', '$package')";
    if ($mysqli->query($sql)) {
        $msg = "Customer created successfully! ID: " . $mysqli->insert_id;
    } else {
        $msg = "Error: " . $mysqli->error;
    }
}
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Create Customer</title>

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
    <a href="index.php?p=admin_customers">← Back to Customers</a>
  </div>

  <main class="container">

    <h2>Create New Customer</h2>

    <?php if ($msg): ?>
        <div class="success"><?= $msg ?></div>
    <?php endif; ?>

    <form method="post">

      <label>Name:</label>
      <input type="text" name="name" required>

      <label>Password:</label>
      <input type="text" name="password" required>

      <label>Package:</label>
      <input type="text" name="package" required>

      <button type="submit">Create Customer</button>

    </form>

  </main>

</body>

</html>
