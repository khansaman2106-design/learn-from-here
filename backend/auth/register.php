<?php
session_start();
require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed.');
}

$name = trim($_POST['name'] ?? '');
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$password = $_POST['password'] ?? '';

if ($name === '' || !$email || strlen($password) < 8) {
    exit('Please enter a name, a valid email and a password of at least 8 characters.');
}

$check = $pdo->prepare('SELECT id FROM users WHERE email = ?');
$check->execute([$email]);
if ($check->fetch()) {
    exit('An account with this email already exists.');
}

$hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = $pdo->prepare('INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)');
$stmt->execute([$name, $email, $hash]);

$_SESSION['user_id'] = (int)$pdo->lastInsertId();
$_SESSION['user_name'] = $name;
header('Location: ../../frontend/pages/your-pages/student-dashboard.html');
exit;
