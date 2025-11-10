<?php
// Dangerous: creates DB rows. Run locally, then delete this file.
require_once __DIR__ . '/../includes/db.php';
// create tables if not exist
$queries = [
"CREATE TABLE IF NOT EXISTS users (id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(100) UNIQUE, password VARCHAR(255), role ENUM('admin','worker','customer') DEFAULT 'customer')",
"CREATE TABLE IF NOT EXISTS workers (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(200), password VARCHAR(255), field VARCHAR(200), salary DECIMAL(10,2) DEFAULT 0)",
"CREATE TABLE IF NOT EXISTS customers (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(200), password VARCHAR(255), activated_package VARCHAR(200))"
];
foreach($queries as $q) { $mysqli->query($q); }
// insert admin and sample worker/customer if not exists
$res = $mysqli->query("SELECT id FROM users WHERE username='admin' LIMIT 1");
if (!$res->fetch_assoc()) {
    $mysqli->query("INSERT INTO users (username,password,role) VALUES ('admin','admin123','admin')"); echo 'Created admin (admin/admin123)<br>';
}
$res = $mysqli->query("SELECT id FROM workers WHERE name='Worker One' LIMIT 1");
if (!$res->fetch_assoc()) {
    $mysqli->query("INSERT INTO workers (name,password,field,salary) VALUES ('Worker One','worker123','Network',300)"); $wid = $mysqli->insert_id;
    $mysqli->query("INSERT INTO users (username,password,role) VALUES ('worker".$wid."','worker123','worker')"); echo 'Created worker, login username: worker'. $wid . ' password worker123<br>';
}
$res = $mysqli->query("SELECT id FROM customers WHERE name='Customer One' LIMIT 1");
if (!$res->fetch_assoc()) {
    $mysqli->query("INSERT INTO customers (name,password,activated_package) VALUES ('Customer One','cust123','Basic')"); $cid = $mysqli->insert_id;
    $mysqli->query("INSERT INTO users (username,password,role) VALUES ('customer".$cid."','cust123','customer')"); echo 'Created customer, login username: customer'. $cid . ' password cust123<br>';
}
echo '<hr>Setup done. DELETE pages/setup.php AFTER running this on your local machine.';
?>