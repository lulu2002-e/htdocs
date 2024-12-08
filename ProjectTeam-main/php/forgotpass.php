<?php
// Database configuration
$host = 'localhost';       // Database host
$dbName = 'room_booking';    // Database name
$username = 'root';        // Database username
$password = '';            // Database password

// Create connection
$conn = new mysqli($host, $username, $password, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format!'); window.location.href = 'forgotpass.html';</script>";
        exit;
    }

    // Check if email exists in the database
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            // Generate a unique token
            $token = bin2hex(random_bytes(32));

            // Set token expiry time (1 hour from now)
            $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

            // Store the token and expiry in the database
            $updateSql = "UPDATE users SET reset_token = ?, reset_token_expiry = ? WHERE email = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("sss", $token, $expiry, $email);

            if ($updateStmt->execute()) {
                // Create the password reset link
                $resetLink = "http://yourdomain.com/reset-password.php?token=$token";

                // Send email (use a real email library in production)
                $subject = "Password Reset Request";
                $message = "Hello,\n\nYou requested a password reset. Click the link below to reset your password:\n$resetLink\n\nThe link is valid for 1 hour.\n\nIf you did not request this, please ignore this email.";
                $headers = "From: noreply@itcollege.com";

                if (mail($email, $subject, $message, $headers)) {
                    echo "<script>alert('Password reset link sent to your email.'); window.location.href = 'login.html';</script>";
                } else {
                    echo "<script>alert('Failed to send email. Please try again later.'); window.location.href = 'forgotpass.html';</script>";
                }
            } else {
                echo "<script>alert('Failed to store reset token. Please try again later.'); window.location.href = 'forgotpass.html';</script>";
            }
        } else {
            echo "<script>alert('No account found with this email.'); window.location.href = 'forgotpass.html';</script>";
        }

        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Close the connection
$conn->close();
?>

