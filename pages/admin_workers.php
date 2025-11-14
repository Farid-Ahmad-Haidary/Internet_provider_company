<?php 
include __DIR__ . '/../includes/db.php';
if (empty($_SESSION['user'])) {
  header('Location: index.php?p=login');
  exit;
}

$res = $mysqli->query("SELECT * FROM workers ORDER BY id DESC");
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Workers - Vulnerable</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
    .container { max-width: 1200px; margin: 0 auto; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }
  </style>
</head>
<body>
  <div style="background:#333;color:white;padding:15px;">
    <strong>KHAWAR BRIDGE</strong> | 
    <a href="index.php?p=dashboard" style="color:white;">Dashboard</a> |
    <a href="index.php?p=admin_workers" style="color:white;">Workers</a> |
    <a href="index.php?p=admin_customers" style="color:white;">Customers</a> |
    <a href="index.php?p=logout" style="color:white;">Logout</a>
  </div>

  <main class="container">
    <h2>Worker Management 🔓</h2>
    
    <p><a href="index.php?p=admin_worker_create" style="background:#28a745;color:white;padding:10px 15px;text-decoration:none;border-radius:4px;">Create New Worker</a></p>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Password</th>
          <th>Field</th>
          <th>Salary</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($r = $res->fetch_assoc()): ?>
          <tr>
            <td><?= $r['id'] ?></td>
            <td><?= $r['name'] ?></td>
            <td style="color:red;"><?= $r['password'] ?></td>
            <td><?= $r['field'] ?></td>
            <td>$<?= $r['salary'] ?></td>
            <td>
              <a href="index.php?p=admin_worker_edit&id=<?= $r['id'] ?>" style="background:#007bff;color:white;padding:5px 10px;text-decoration:none;border-radius:3px;">Edit</a>
              <a href="index.php?p=admin_worker_delete&id=<?= $r['id'] ?>" onclick="return confirm('Delete worker?')" style="background:#dc3545;color:white;padding:5px 10px;text-decoration:none;border-radius:3px;">Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </main>
</body>
</html>