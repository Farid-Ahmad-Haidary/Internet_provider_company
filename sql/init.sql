CREATE DATABASE IF NOT EXISTS internet_isp_vuln_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE internet_isp_vuln_db;
CREATE TABLE IF NOT EXISTS users (id INT AUTO_INCREMENT PRIMARY KEY, 
username VARCHAR(100) UNIQUE, password VARCHAR(255), role ENUM('admin','worker','customer') DEFAULT 'customer');
CREATE TABLE IF NOT EXISTS workers (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(200), password VARCHAR(255), field VARCHAR(200), salary DECIMAL(10,2) DEFAULT 0);
CREATE TABLE IF NOT EXISTS customers (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(200), password VARCHAR(255), activated_package VARCHAR(200));
