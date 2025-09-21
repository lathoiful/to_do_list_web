<?php
$host = 'localhost';
$db   = 'todo';      // nama database
$user = 'root';      // user default XAMPP
$pass = '';          // password default kosong di XAMPP
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    exit('DB connection failed: ' . $e->getMessage());
}
