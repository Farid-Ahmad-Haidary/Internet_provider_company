<?php include __DIR__ . '/../includes/db.php';
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') { header('Location: index.php?p=login'); exit; }
$res = $mysqli->query('SELECT id,name,password,field,salary FROM workers ORDER BY id DESC');
?>
<!doctype html><html><head><meta charset="utf-8"><title>Workers</title><link rel="stylesheet" href="assets/styles.css"></head>
<body><?php include 'parts/topbar.php'; ?>
<main class="container">
  <h2>Workers</h2>
  <p><a href="index.php?p=admin_worker_create">Create Worker</a></p>
  <table class="table"><thead><tr><th>ID</th><th>Name</th><th>Password</th><th>Field</th><th>Salary</th><th>Actions</th></tr></thead><tbody>
  <?php while($r=$res->fetch_assoc()): ?>
    <tr>
      <td><?=$r['id']?></td>
      <td><?=htmlspecialchars($r['name'])?></td>
      <td><?=htmlspecialchars($r['password'])?></td>
      <td><?=htmlspecialchars($r['field'])?></td>
      <td><?=htmlspecialchars($r['salary'])?></td>
      <td><a href="index.php?p=admin_worker_edit&id=<?=$r['id']?>">Edit</a> | <a href="index.php?p=admin_worker_delete&id=<?=$r['id']?>" onclick="return confirm('Delete?')">Delete</a></td>
    </tr>
  <?php endwhile; ?>
  </tbody></table>
</main>
<?php include 'parts/footer.php'; ?></body></html>
