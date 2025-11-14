<?php
include __DIR__ . '/../includes/db.php';
if (empty($_SESSION['user'])) {
  header('Location: index.php?p=login');
  exit;
}

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $password = $_POST['password'] ?? '';
    $package = $_POST['package'] ?? '';
    
    // VULNERABLE INSERT - SQL Injection
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
    body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
    .container { max-width: 600px; margin: 0 auto; }
    input, button { width: 100%; padding: 8px; margin: 5px 0; }
  </style>
</head>
<body>
  <div style="background:#333;color:white;padding:15px;">
    <a href="index.php?p=admin_customers" style="color:white;">← Back to Customers</a>
  </div>

  <main class="container">
    <h2>Create New Customer</h2>
    
    <?php if ($msg): ?>
        <div style="background:#d4edda;padding:10px;border-radius:4px;"><?= $msg ?></div>
    <?php endif; ?>

    <form method="post">
        <label>Name:</label>
        <input type="text" name="name" required>
        
        <label>Password:</label>
        <input type="text" name="password" required>
        
        <label>Package:</label>
        <input type="text" name="package" required>
        
        <button type="submit" style="background:#28a745;color:white;border:none;padding:10px;">Create Customer</button>
    </form>
  </main>
</body>
</html>