<?php
session_start();
require 'db_connection.php';

if (!isset($_SESSION['user_id']) || !filter_var($_SESSION['user_id'], FILTER_VALIDATE_INT)) {
    header('Location: login.php');
    exit;
}

$user_id = intval($_SESSION['user_id']);

try {
    $stmt = $pdo->prepare("SELECT id, name, email, profile_picture FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("User not found. Please contact support.");
    }

    // Example: Return user data as JSON for an API or frontend
    header('Content-Type: application/json');
    echo json_encode($user);

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>