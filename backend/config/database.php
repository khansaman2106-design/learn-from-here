<?php
// XAMPP default settings. Change these if your MySQL credentials differ.
$host = 'localhost';
$dbname = 'learn_from_here';
$username = 'root';
$password = '';

try {
    $pdo = new PDO(
        "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
        $username,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
} catch (PDOException $e) {
    // Do not show database credentials or internal errors to site visitors.
    http_response_code(500);
    exit('Database connection failed. Check backend/config/database.php and the MySQL service.');
}
