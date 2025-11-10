<?php include __DIR__ . '/../includes/db.php';
session_start();
if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'customer') {
  header('Location: index.php?p=login');
  exit;
}
$uid = $_SESSION['user']['id'];
$res = $mysqli->query("SELECT * FROM customers WHERE id=$uid LIMIT 1");
$c = $res->fetch_assoc();
if (!$c) exit('Details missing'); ?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>My Details</title>
  <link rel="stylesheet" href="assets/styles.css">
</head>

<body><?php include 'parts/topbar.php'; ?><main class="container">
    <h2>My Customer Details</h2>
    <table class="table">
      <tr>
        <th>Name</th>
        <td><?= htmlspecialchars($c['name']) ?></td>
      </tr>
      <tr>
        <th>Activated Package</th>
        <td><?= htmlspecialchars($c['activated_package']) ?></td>
      </tr>
    </table>
  </main><?php include 'parts/footer.php'; ?></body>

</html>