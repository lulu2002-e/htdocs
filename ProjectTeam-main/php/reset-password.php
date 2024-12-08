<?php
include 'db_connection.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if token is provided in the URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Validate the token
    $sql = "SELECT * FROM users WHERE reset_token = ? AND reset_token_expiry > NOW()";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Token is valid, display password reset form
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $newPassword = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

            // Update the user's password
            $updateSql = "UPDATE users SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE reset_token = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("ss", $newPassword, $token);

            if ($updateStmt->execute()) {
                echo "<script>alert('Password has been reset successfully!'); window.location.href = 'login.html';</script>";
            } else {
                echo "<script>alert('Failed to reset password. Please try again.'); window.location.href = 'reset-password.php?token=$token';</script>";
            }
        }
    } else {
        echo "<script>alert('Invalid or expired token.'); window.location.href = 'forgotpass.html';</script>";
    }
} 
   
