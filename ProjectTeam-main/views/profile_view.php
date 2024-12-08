<?php
session_start();
require 'db_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || !filter_var($_SESSION['user_id'], FILTER_VALIDATE_INT)) {
    header('Location: login.php');
    exit;
}

$user_id = intval($_SESSION['user_id']);

// Fetch user data
try {
    $stmt = $pdo->prepare("SELECT name, email, profile_picture FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("User not found. Please contact support.");
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!-- HTML for displaying the profile -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Profile</title>
</head>
<body>
    <h1>Your Profile</h1>
    <p><strong>Name:</strong> <?= htmlspecialchars($user['name']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
    <p><strong>Profile Picture:</strong></p>
    <img src="<?= htmlspecialchars($user['profile_picture']) ?>" alt="Profile Picture" width="150"><br><br>
    <a href="profile-edit.php">Edit Profile</a>
</body>
</html>