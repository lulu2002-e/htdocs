<?php
session_start();
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate session user ID
    if (!isset($_SESSION['user_id']) || !filter_var($_SESSION['user_id'], FILTER_VALIDATE_INT)) {
        die("Invalid user session.");
    }

    $user_id = intval($_SESSION['user_id']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $old_password = trim($_POST['old_password']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validate input fields
    if (empty($name) || empty($email)) {
        die("Name and email cannot be empty.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email address.");
    }

    // Handle password change if fields are provided
    if (!empty($old_password) || !empty($new_password) || !empty($confirm_password)) {
        $stmt = $pdo->prepare("SELECT password_hash FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($old_password, $user['password_hash'])) {
            die("Current password is incorrect.");
        }

        if (strlen($new_password) < 8) {
            die("New password must be at least 8 characters long.");
        }

        if ($new_password !== $confirm_password) {
            die("New password and confirmation do not match.");
        }

        $new_password_hash = password_hash($new_password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
        $stmt->execute([$new_password_hash, $user_id]);
    }

    // Update name and email
    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
    $stmt->execute([$name, $email, $user_id]);

    echo "Profile updated successfully!";
}
?>