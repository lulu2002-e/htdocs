<?php
session_start();
include 'db_connection.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Protected Page</title>
</head>
<body>
    <h2>Welcome to the Protected Page</h2>
    <p>Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
    <p>This is a protected page that only logged-in users can access.</p>
    <a href="logout.php">Logout</a>
</body>
</html>
