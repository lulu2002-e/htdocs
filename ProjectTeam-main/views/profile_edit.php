<?php
session_start();
require 'db_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || !filter_var($_SESSION['user_id'], FILTER_VALIDATE_INT)) {
    header('Location: login.php');
    exit;
}

$user_id = intval($_SESSION['user_id']);

// Fetch user data to prefill the form
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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $old_password = trim($_POST['old_password']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);
    $profile_image = $_FILES['profile_image'];

    // Validate input fields
    if (empty($name) || empty($email)) {
        die("Name and email cannot be empty.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email address.");
    }

    // Handle profile image upload
    if (isset($profile_image) && $profile_image['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 2 * 1024 * 1024; // 2 MB

        $file_tmp = $profile_image['tmp_name'];
        $file_name = basename($profile_image['name']);
        $file_size = $profile_image['size'];
        $file_type = mime_content_type($file_tmp);

        // Validate file type and size
        if (!in_array($file_type, $allowed_types)) {
            die("Invalid file type. Only JPG, PNG, and GIF are allowed.");
        }

        if ($file_size > $max_size) {
            die("File size exceeds 2 MB.");
        }

        // Generate a unique file name to prevent overwriting
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $new_file_name = uniqid('profile_', true) . '.' . $file_ext;

        // Move the uploaded file to the uploads directory
        $file_path = $upload_dir . $new_file_name;
        if (!move_uploaded_file($file_tmp, $file_path)) {
            die("Failed to upload the profile image. Ensure uploads directory is writable.");
        }

        // Update the user's profile image in the database
        $stmt = $pdo->prepare("UPDATE users SET profile_picture = ? WHERE id = ?");
        $stmt->execute([$file_path, $user_id]);
    }

    // Handle password change if fields are provided
    if (!empty($old_password) || !empty($new_password) || !empty($confirm_password)) {
        $stmt = $pdo->prepare("SELECT password_hash FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user_data || !password_verify($old_password, $user_data['password_hash'])) {
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

<!-- HTML Form for profile editing -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
</head>
<body>
    <h1>Edit Profile</h1>
    <form method="POST" enctype="multipart/form-data">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required><br><br>

        <label for="profile_image">Profile Picture:</label><br>
        <input type="file" id="profile_image" name="profile_image"><br><br>

        <label for="old_password">Old Password:</label><br>
        <input type="password" id="old_password" name="old_password"><br><br>

        <label for="new_password">New Password:</label><br>
        <input type="password" id="new_password" name="new_password"><br><br>

        <label for="confirm_password">Confirm New Password:</label><br>
        <input type="password" id="confirm_password" name="confirm_password"><br><br>

        <button type="submit">Save Changes</button>
    </form>
</body>
</html>