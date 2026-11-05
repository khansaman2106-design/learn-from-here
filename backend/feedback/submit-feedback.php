<?php
require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed.');
}

$name = trim($_POST['name'] ?? '');
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$message = trim($_POST['message'] ?? '');
$rating = filter_var($_POST['rating'] ?? null, FILTER_VALIDATE_INT);

if ($name === '' || !$email || $message === '' || !$rating || $rating < 1 || $rating > 5) {
    exit('Please complete all fields and select a rating from 1 to 5.');
}

$stmt = $pdo->prepare('INSERT INTO feedback (name, email, rating, message) VALUES (?, ?, ?, ?)');
$stmt->execute([$name, $email, $rating, $message]);
echo 'Thank you! Your feedback has been submitted.';
