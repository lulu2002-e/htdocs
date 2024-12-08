<?php
session_start();
include 'db_connection.php';


// If user is already logged in, redirect to the protected page
if (isset($_SESSION['user_id'])) {
    header("Location: protected_page.php");
    exit();}

    if (isset($_SESSION['login_error'])) {
        echo "<p style='color: red;'>" . $_SESSION['login_error'] . "</p>";
        unset($_SESSION['login_error']);
    }
    if (isset($_SESSION['registration_success'])) {
        echo "<p style='color: green;'>" . $_SESSION['registration_success'] . "</p>";
        unset($_SESSION['registration_success']);
}
?>