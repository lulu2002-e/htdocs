<?php
session_start();
require 'db_connection.php';

if (!isset($_SESSION['user_id']) || !filter_var($_SESSION['user_id'], FILTER_VALIDATE_INT)) {
    header('Location: login.php');
    exit;
}

$user_id = intval($_SESSION['user_id']);
$stmt = $pdo->prepare("SELECT name, email, profile_picture FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found. Please contact support.");
}

// Example of returning user data as JSON (optional, if needed for an API)
header('Content-Type: application/json');
echo json_encode($user);
?>