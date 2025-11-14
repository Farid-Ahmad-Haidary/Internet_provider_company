<?php 
include __DIR__ . '/../includes/db.php';
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header('Location: index.php?p=login');
  exit;
}

// Fetch customers
$res = $mysqli->query("SELECT id,name,password,activated_package FROM customers ORDER BY id DESC");
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Customers</title>
  <link rel="stylesheet" href="assets/styles.css">

  <style>
    /* Page Title */
    h2 {
      font-size: 26px;
      margin-bottom: 18px;
      color: #0b9488;
      font-weight: 700;
    }

    /* Create button */
    .create-btn {
      display: inline-block;
      padding: 0.6rem 1rem;
      background: #0b9488;
      color: #fff !important;
      text-decoration: none;
      border-radius: 8px;
      font-weight: 600;
      box-shadow: 0 6px 18px rgba(11, 148, 136, 0.15);
      transition: 0.15s ease-in-out;
    }

    .create-btn:hover {
      background: #097a70;
      transform: translateY(-2px);
      box-shadow: 0 10px 22px rgba(11, 148, 136, 0.25);
    }

    /* Action buttons */
    .btn-edit {
      background: #0d6efd;
      color: #fff !important;
      padding: 6px 12px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: 600;
      margin-right: 6px;
      display: inline-block;
      box-shadow: 0 6px 12px rgba(13, 110, 253, 0.18);
      transition: 0.15s ease;
    }

    .btn-edit:hover {
      background: #0b5ed7;
      transform: translateY(-2px);
    }

    .btn-delete {
      background: #dc3545;
      color: #fff !important;
      padding: 6px 12px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: 600;
      display: inline-block;
      box-shadow: 0 6px 12px rgba(220, 53, 69, 0.18);
      transition: 0.15s ease;
    }

    .btn-delete:hover {
      background: #bb2d3b;
      transform: translateY(-2px);
    }

    /* Table */
    table.table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
    }

    table.table thead {
      background: #0b9488;
      color: white;
      font-weight: 700;
    }

    table.table th,
    table.table td {
      padding: 12px 15px;
      border-bottom: 1px solid #e9ecef;
      font-size: 15px;
    }

    table.table tbody tr:hover {
      background: #f6fdfd;
    }
  </style>
</head>

<body>

<?php include 'parts/topbar.php'; ?>

<main class="container">

  <h2>Customers</h2>

  <p><a class="create-btn" href="index.php?p=admin_customer_create">➕ Create Customer</a></p>

  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Password</th>
        <th>Package</th>
        <th>Actions</th>
      </tr>
    </thead>

    <tbody>
      <?php while ($r = $res->fetch_assoc()): ?>
        <tr>
          <td><?= $r['id'] ?></td>
          <td><?= htmlspecialchars($r['name']) ?></td>
          <td><?= htmlspecialchars($r['password']) ?></td>
          <td><?= htmlspecialchars($r['activated_package']) ?></td>
          <td>
            <a class="btn-edit" href="index.php?p=admin_customer_edit&id=<?= $r['id'] ?>">✏️ Edit</a>
            <a class="btn-delete" href="index.php?p=admin_customer_delete&id=<?= $r['id'] ?>" onclick="return confirm('Are you sure you want to delete this customer?')">🗑️ Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>

  </table>

</main>

<?php include 'parts/footer.php'; ?>

</body>
</html>
