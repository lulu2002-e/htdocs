<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user data from the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id']; 
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role']; 

            // Redirect based on role
            if ($user['role'] === 'admin') {
                header("Location: admin_dashboard.php"); // Redirect admins
            } else { //fix the name of php if not the same:( 
                header("Location: user_dashboard.php"); // Redirect regular users
            }
            exit();
        } else {
            $_SESSION['login_error'] = "Invalid username or password";
        }
    } else {
        $_SESSION['login_error'] = "Invalid username or password";
    }

    header("Location: login.php");
    exit();
}

?>
    
