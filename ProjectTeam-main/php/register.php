<?php
// Check if form data is sent via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect POST data from the form
    $username = $_POST['username'];  // Correct field name as per HTML form
    $email = $_POST['email'];
    $password = $_POST['password'];  // You should hash the password
    $confirmPassword = $_POST['confirmPassword'];  // Adding the confirmPassword field
    $role = $_POST['role'];  // Role from the select input

    // Basic validation to check if passwords match
    if ($password !== $confirmPassword) {
        echo "Passwords do not match. Please try again.";
        exit();
    }

    // Basic validation to check if fields are empty
    if (empty($username) || empty($email) || empty($password) || empty($role)) {
        echo "Please fill in all fields.";
        exit();
    }

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'room_booking');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL statement to insert the user into the database
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $hashed_password, $role);

    // Execute the query
    $execval = $stmt->execute();
    if ($execval) {
        echo "Registration successful!";
        // Optionally, redirect to another page after success
        header("Location: login.php"); // Redirect to login page
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Redirect if the form was not submitted via POST
    header("Location: register.php");
    exit();
}
?>