<?php
$mysqli = new mysqli('localhost', 'root', '', 'internet_isp_vuln_db');
if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}
?>