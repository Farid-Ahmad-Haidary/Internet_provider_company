<?php
require_once __DIR__ . '/includes/db.php';
session_start();

$path = $_GET['p'] ?? 'login';

switch ($path) {
    case 'login':
        include 'pages/login.php';
        break;
    case 'logout':
        include 'pages/logout.php';
        break;
    case 'setup':
        include 'pages/setup.php';
        break;
    case 'dashboard':
        include 'pages/dashboard.php';
        break;
    case 'admin_workers':
        include 'pages/admin_workers.php';
        break;
    case 'admin_worker_create':
        include 'pages/admin_worker_create.php';
        break;
    case 'admin_worker_edit':
        include 'pages/admin_worker_edit.php';
        break;
    case 'admin_worker_delete':
        include 'pages/admin_worker_delete.php';
        break;
    case 'admin_customers':
        include 'pages/admin_customers.php';
        break;
    case 'admin_customer_create':
        include 'pages/admin_customer_create.php';
        break;
    case 'admin_customer_edit':
        include 'pages/admin_customer_edit.php';
        break;
    case 'admin_customer_delete':
        include 'pages/admin_customer_delete.php';
        break;
    case 'worker_profile':
        include 'pages/worker_profile.php';
        break;
    case 'customer_view':
        include 'pages/customer_view.php';
        break;
    default:
        echo 'Not found';
        break;
}