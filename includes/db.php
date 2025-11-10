<?php
$host='127.0.0.1';
$user='root';
$pass='';
$db='internet_isp_vuln_db';
$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_errno) { die("DB connect failed: " . $mysqli->connect_error); }
$mysqli->set_charset('utf8mb4');
?>