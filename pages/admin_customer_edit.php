<?php
include __DIR__ . '/../includes/db.php';
if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header('Location: index.php?p=login');
  exit;
}

$id = $_GET['id'] ?? 0;
$res = $mysqli->query("SELECT * FROM customers WHERE id = $id LIMIT 1");
$c = $res->fetch_assoc();
if (!$c) exit('Customer not found');

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'] ?? $c['name'];
  $password = $_POST['password'] ?? $c['password'];
  $pkg = $_POST['activated_package'] ?? $c['activated_package'];

  // VULNERABLE SQL
  $mysqli->query("UPDATE customers SET name='$name', password='$password', activated_package='$pkg' WHERE id=$id");

  $msg = 'Saved';
  $res = $mysqli->query("SELECT * FROM customers WHERE id = $id LIMIT 1");
  $c = $res->fetch_assoc();
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Edit Customer</title>
</head>
<body style="margin:0;font-family:Arial;background:#ffffff;">

  <?php include 'parts/topbar.php'; ?>

  <main style="max-width:600px;margin:40px auto;padding:25px;
               background:#fff;border-radius:10px;
               box-shadow:0 4px 20px rgba(0,0,0,0.08);">

    <h2 style="margin-bottom:20px;color:#0b9488;">Edit Customer</h2>

    <?php if ($msg) echo '<div style="padding:10px;background:#d4edda;color:#155724;border-radius:6px;margin-bottom:15px;">' . htmlspecialchars($msg) . '</div>'; ?>

    <form method="post">

      <label style="font-weight:bold;color:#333;">Name</label>
      <input name="name" value="<?= $c['name'] ?>" 
             style="width:100%;padding:10px;margin:6px 0 15px;
             border:1px solid #ccc;border-radius:6px;">

      <label style="font-weight:bold;color:#333;">Password</label>
      <input name="password" value="<?= $c['password'] ?>" 
             style="width:100%;padding:10px;margin:6px 0 15px;
             border:1px solid #ccc;border-radius:6px;">

      <label style="font-weight:bold;color:#333;">Activated Package</label>
      <input name="activated_package" value="<?= $c['activated_package'] ?>" 
             style="width:100%;padding:10px;margin:6px 0 20px;
             border:1px solid #ccc;border-radius:6px;">

      <button style="width:100%;padding:12px;
                     background:linear-gradient(90deg, #0b9488, #0fd6bd);
                     border:none;color:white;font-size:16px;
                     border-radius:6px;cursor:pointer;">
        Save
      </button>

    </form>
  </main>

  <?php include 'parts/footer.php'; ?>

</body>
</html>
